<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        $resetLink = url('/vendor/reset-password/' . $this->token . '?email=' . urlencode($this->email));

        return $this->subject('Vendor Password Reset')
                    ->view('emails.vendor-reset-password')
                    ->with(['resetLink' => $resetLink]);
    }
}
