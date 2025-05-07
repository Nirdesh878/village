<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DartOtp extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {

        $this->data['data'] = $data;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // pr("hello");
        // prd($this->data);
        return $this->view('emails.OtpMail',$this->data);

    }
}
