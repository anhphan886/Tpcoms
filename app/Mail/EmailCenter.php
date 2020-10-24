<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailCenter;

class EmailCenter
{

    protected $tables = [];

    public function __construct($array)
    {
        $this->tables = $array;
    }

    public function run()
    {
        foreach (array_keys($this->tables) as $mailTable) {

            $mail = app()->get($mailTable);

            $mailProp = $this->tables[$mailTable];
//                 Log::info($mailProp);
            if (count($mailProp) == 0) {
                $mailProp = [
                    'to_address' => 'to_address',
                    'body_html' => 'body_html',
                    'is_sent' => 'is_sent',
                    'date_sent' => 'date_sent',
                    'subject' => 'subject',
                ];
            }
            $key = array_values($mailProp);
            $key[] = 'id';
            $notSentMail = $mail->getList(array_values($mailProp), $mailProp['is_sent']);
            foreach ($notSentMail as $nsm) {
                // call function send mail
                if (empty($nsm[$mailProp['date_sent']]) || Carbon::parse($nsm[$mailProp['date_sent']]) < Carbon::now()) {
                    Mail::to($nsm[$mailProp['to_address']])->send(new MailCenter($nsm[$mailProp['body_html']], $nsm[$mailProp['subject']]));
                } else {
                    continue;
                }

                // update is sent
                $mail->updateAttribute($nsm['id'], $nsm[$mailProp['is_sent']], 1);
                $mail->updateAttribute($nsm['id'], $nsm[$mailProp['date_sent']], Carbon::now());
            }
        }
    }
}


