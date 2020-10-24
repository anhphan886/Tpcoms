<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Receipt extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'THÔNG BÁO PHIẾU THU SẮP HẾT HẠN THANH TOÁN';
        if (isset($this->data['type']) && $this->data['type'] == 'receipt') {
            $subject = 'THÔNG BÁO THANH TOÁN PHIẾU THU THÀNH CÔNG';
        } else if ($this->data['type'] == 'invoice') {
            return $this->view('product::mail.invoice', [
                'data' => $this->data,
            ])->subject($this->data['subject']);
        }
        return $this->view('admin::mail.remind-receipt', [
            'data' => $this->data,
        ])->subject($subject);
    }
}
