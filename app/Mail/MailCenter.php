<?php

namespace App\Mail;

class MailCenter extends \Illuminate\Mail\Mailable{
    private $data, $subject;
    public function __construct($data, $subject)
    {
        $this->data = $data;
        $this->subject = $subject;
    }
    public function build(){
        return $this->view($this->data)->subject($this->subject);
    }
}

?>
