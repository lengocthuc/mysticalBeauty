<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOtp extends Mailable
{
    use Queueable, SerializesModels;
    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->subject = 'Mã OTP thay đổi mật khẩu website Mystical Beauty';
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $replyTo = $this->data['email'];
        $code = $this->data['code'];
        $subject = $this->subject;

        return $this->subject($subject)->replyTo($replyTo)
            ->view('mails.sendOtp',[
               'otp'=> $code
            ]);
    }
}
