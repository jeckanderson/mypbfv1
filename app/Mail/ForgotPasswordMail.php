<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $resetLink;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $resetLink)
    {
        $this->email = $email;
        $this->resetLink = $resetLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reset Password MyPBF')
            ->view('mail.reset-password-akses')
            ->with([
                'email' => $this->email,
                'resetLink' => $this->resetLink,
            ]);
    }
}