<?php

namespace App\Conversations;

use App\Models\NoticeForOwner;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class SendMessageConversation extends Conversation
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
        $this->askMessage();
    }

    private function askMessage()
    {
        $message = __("Input message") . "\n";
        $message .= "/exit - " . __("Exit");
        $this->ask($message, function (Answer $answer) {
            if ($answer != "/exit") {
                $date = date('Y-m-d');
                $notice = new NoticeForOwner();
                $notice->text = $answer;
                $notice->date = $date;
                $notice->abonent_id=$this->abonent->id;
                $notice->organization_id = $this->abonent->organization_id;
                $notice->save();
            }
        });

    }
}
