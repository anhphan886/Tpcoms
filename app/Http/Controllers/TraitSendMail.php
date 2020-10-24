<?php
namespace App\Http\Controllers;

use App\Entities\EmailMessage;
use App\Jobs\SendEmailJob;

trait TraitSendMail
{
    public function buildEmail($data){
        $arrInsertEmail = [
            'object_id' => $data['object_id'],
            'template_type' => $data['template_type'],
            'email_type' => $data['email_type'],
            'email_subject' => $data['email_subject'],
            'email_to' => $data['email_to'],
            'email_from' => env('MAIL_FROM_ADDRESS'),
            'email_from_name' => env('MAIL_FROM_NAME'),
            'email_cc' => isset($data['email_cc']) ? $data['email_cc'] : '',
            'email_params' => json_encode($data['email_params']),
            'email_attach' => isset($data['email_attach']) ? json_encode($data['email_attach']) : '',
        ];

        $jobEmail = new SendEmailJob($arrInsertEmail);

        dispatch($jobEmail);
    }
}
