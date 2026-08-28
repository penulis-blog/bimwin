<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $dataemail;
    
    public function __construct($dataemail)
    {
        $this->dataemail = $dataemail;
    }

    public function build()
    {
        return $this->subject('Hai, segera aktivasi akun kamu untuk bisa bergabung bersama kami.')->view('register.info_email');
    }
}
