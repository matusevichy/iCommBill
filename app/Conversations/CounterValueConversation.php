<?php

namespace App\Conversations;

use App\Models\Counter;
use App\Models\CounterValue;
use App\Models\Dictionary\AccrualType;
use App\Models\Tarif;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class CounterValueConversation extends Conversation
{
    protected $abonent;

    public function __construct($abonent)
    {
        $this->abonent = $abonent;
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        $this->askAccrualType();
    }

    private function askAccrualType()
    {
        $accrual_types = AccrualType::where('by_counter', true)->get();
        $message = __("Select accrual type") . "\n";
        foreach ($accrual_types as $accrual_type) {
            $message .= "/" . $accrual_type->id . " - " . __($accrual_type->name) . "\n";
        }
        $message .= "/exit - " . __("Exit");
        $this->ask($message, function (Answer $answer) {
            if ($answer != "/exit") {
                $answer = ltrim($answer, "/");
                $date = date('Y-m-d');
                $counter = Counter::where('abonent_id', $this->abonent->id)->where('accrualtype_id', $answer)->
                where('date_begin', '<', $date)->
                where(function ($query) use ($date) {
                    $query->where('date_end', null)->orWhere('date_end', '>', $date);
                })->first();
                if ($counter != null) {
                    $this->askCounterValue($counter);
                } else {
                    $this->say(__("Counter for this accrual type is absent"));
                    $this->repeat();
                }
            }
        });
    }

    private function askCounterValue($counter)
    {
        $last_value = CounterValue::where('counter_id', $counter->id)
            ->where('is_real', true)->orderBy('date', 'desc')->first();
        $this->say(__("Last value") . " " . $last_value->value . " " . __("on date") . " " . $last_value->date);
        $this->ask(__("Enter the counter value as an integer") . "\n" . "/exit - " . __("Exit"),
            function (Answer $answer) use ($counter, $last_value) {
                if ($answer != "/exit") {
                    $date = date('Y-m-d');
                    if (floatval($answer->getText()) > $last_value->value) {
                        $counter_value = new CounterValue();
                        $counter_value->value = $answer;
                        $counter_value->date = $date;
                        $counter_value->is_real = true;
                        $counter_value->is_blocked = false;
                        $counter_value->counter_id = $counter->id;
                        $counter_value->save();

                        $this->say(__("Value accepted"));

                        $tarif = Tarif::where('accrualtype_id', $counter->accrualtype_id)
                            ->where('date_begin', '<', $date)
                            ->where(function ($query) use ($date) {
                                $query->where('date_end', null)->orWhere('date_end', '>', $date);})->first();
                        if ($tarif == null) {
                            $this->say('On date ' . $date . ' organization hasn`t tarif. Accrual is not available!');
                        }
                        else{
                            create_accrual_by_counter($counter->id);
                        }
                    } else {
                        $this->say(__("Incorrect value"));
                        $this->repeat();
                    }
                }
            });
    }
}
