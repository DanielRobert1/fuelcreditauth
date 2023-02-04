<?php

namespace App\Listeners\Auth;

use App\Mail\Auth\WelcomeMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Registered $event
     * @return void
     */
    public function handle(Registered $event): void
    {
        Mail::to($event->user->email)->queue(new WelcomeMail($event->user));
    }
}
