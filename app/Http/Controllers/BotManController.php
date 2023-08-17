<?php

namespace App\Http\Controllers;

use App\Conversations\CounterValueConversation;
use App\Models\Abonent;
use App\Models\CounterValue;
use App\Models\Dictionary\AccrualType;
use App\Models\Notice;
use App\Models\Organization;
use App\Models\User;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use BotMan\Drivers\Telegram\TelegramDriver;


class BotManController extends Controller
{
    public function handle()
    {
        DriverManager::loadDriver(TelegramDriver::class);

        $config = [
            'user_cache_time' => 720,

            'config' => [
                'conversation_cache_time' => 720,
            ],

            "telegram" => [
                "token" => env('TELEGRAM_TOKEN'),
            ]
        ];

        $start_message = "/start - " . __('commands list') . "\n/abonents - " . __('personal accounts list');
        // // Create BotMan instance
        $botman = BotManFactory::create($config, new LaravelCache());

        $botman->hears('/start{token}|start', function (BotMan $bot, $token) use ($start_message) {
            $message = "";
            if ($token != "") {
                $token = trim($token);
                $user = User::where('remember_token', '=', $token)->first();
                if ($user != null) {
                    $message = __('Hi') . ", " . $user->name . "\n" . $start_message;
                    $user->telegram_bot_id = $bot->getUser()->getId();
                    $user->save();
                } else {
                    $message = __("You are not authorized");
                }
            } else {
                $user = User::where('telegram_bot_id', '=', $bot->getUser()->getId())->first();
                if ($user != null) {
                    $message = $start_message;
                } else {
                    $message = __("You are not authorized");
                }
            }
            $bot->reply($message);
        });

        $botman->hears('/abonents', function (BotMan $bot) {
            $user = $this->getUser($bot->getUser()->getId());
            if ($user != null) {
                $bot->reply(__("You personal accounts"));
                $abonents = Abonent::where('user_id', $user->id)->get();
                $message = "";
                foreach ($abonents as $abonent) {
                    $message .= "/" . $abonent->account_number . "\n";
                }
            } else {
                $message = __("You are not authorized");
            }
            $bot->reply($message);
        });

        $botman->hears('/([0-9]+)(arrears|notices|put_value|)', function (BotMan $bot, $account, $command) {
            $user = $this->getUser($bot->getUser()->getId());
            if ($user != null) {
                $keyboard = Keyboard::create()->type(Keyboard::TYPE_INLINE)
                    ->oneTimeKeyboard(true)
                    ->addRow(
                        KeyboardButton::create(__('Arrears'))->callbackData('/' . $account . 'arrears'),
                        KeyboardButton::create(__("Notices"))->callbackData('/' . $account . 'notices'),
                        KeyboardButton::create(__("Put counter value"))->callbackData('/' . $account . 'put_value')
                    )
                    ->toArray();
                $abonent = Abonent::where('account_number', $account)->where('user_id', $user->id)->first();
                if ($command == null) {
                    $this->get_abonent_info($bot, $abonent, $keyboard);
                }
                if ($command == 'arrears') {
                    $this->get_abonent_arrears($bot, $abonent, $keyboard);
                }
                if ($command == 'notices') {
                    $this->get_notices($bot, $abonent, $keyboard);
                }
                if ($command == 'put_value') {
                    $bot->startConversation(new CounterValueConversation($abonent));
                }
            } else {
                $message = __("You are not authorized");
                $bot->reply($message);
            }
        });


        $botman->fallback(function ($bot) use ($start_message) {
            $bot->reply(__("Sorry, I did not understand these commands. Here is a list of commands I understand") . ": \n" . $start_message);
        });

        $botman->listen();

    }

    private function getUser($telegram_bot_id)
    {
        return User::where('telegram_bot_id', $telegram_bot_id)->first();

    }

    private function get_abonent_info(BotMan $bot, $abonent, array $keyboard)
    {
        if ($abonent == null) {
            $bot->reply(__("Account not found"));
        } else {
            $bot->reply(__("Account number") . ": " . $abonent->account_number . "\n" .
                __("Location number") . ": " . $abonent->location_number . "\n" .
                __("Street") . ": " . $abonent->street . "\n" .
                __("Square") . ": " . $abonent->square . "\n" .
                __("Organization") . ": " . $abonent->organization->name . "\n" .
                __("Arrears") . ": " . get_abonent_saldo($abonent->id), $keyboard, ['parse_mode' => 'HTML']);
        }
    }

    private function get_abonent_arrears(BotMan $bot, $abonent, array $keyboard)
    {
        $accrual_types = AccrualType::all();
        $message = "";
        foreach ($accrual_types as $accrual_type) {
            $message .= __($accrual_type->name) . ": " . get_abonent_saldo_by_accrual_type($abonent->id, $accrual_type->id) . "\n";
        }
        $bot->reply($message, $keyboard, ['parse_mode' => 'HTML']);
    }

    private function get_notices(BotMan $bot, $abonent, array $keyboard)
    {
        $date = date('Y-m-d');
        $notices = Notice::where('organization_id', $abonent->organization_id)
            ->where('date_begin', '<=', $date)
            ->where(function ($query) use ($date) {
                $query->where('date_end', null)->orWhere('date_end', '>=', $date);
            })->get();
        $message = "";
        foreach ($notices as $notice) {
            $message .= $notice->text . "\n";
        }
        $bot->reply($message, $keyboard, ['parse_mode' => 'HTML']);
    }

}
