<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $password;

 
    public function __construct($user)
    {
        $this->user = $user;
    }
    
    public function build()
    {
        return $this->subject("Welcome to Fuel Credit")->markdown('emails.welcome');
    }
}
