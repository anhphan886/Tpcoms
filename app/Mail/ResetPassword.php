<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $rand_sting;

    public function __construct($rand_sting)
    {
        $this->rand_sting = $rand_sting;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('core::forget-password.email-reset-pass', [
            'token' => $this->rand_sting,
            'link' => ''
        ])->subject("Reset password instructions");
    }
}
