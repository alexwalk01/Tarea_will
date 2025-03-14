<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }
    
    public function build()
    {
        return $this->subject('Confirma tu inicio de sesión')
            ->view('emails.login_confirmation')
            ->with([
                'url_yes' => route('confirm.login', ['token' => $this->token, 'confirm' => 'yes']),
            ]);
    }
    
}
