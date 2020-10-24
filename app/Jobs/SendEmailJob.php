<?php
namespace App\Jobs;

use App\Entities\EmailMessage;
use App\Mail\SendMailable;
use Illuminate\Support\Facades\Mail;

class SendEmailJob extends BaseJob
{
    protected $message;

    /**
     * SendEmailJob constructor.
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    }
}

