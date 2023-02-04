<?php

namespace App\Listeners\Auth;

use App\Events\Auth\Authenticated;
use App\Mail\Auth\NewDeviceSignIn;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class UpdateNewDevice implements ShouldQueue
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
     * @param Authenticated $event
     * @return void
     */
    public function handle(Authenticated $event): void
    {
        $user = $event->user;
        $data = $event->requestData;

        $isDeviceSaved = $user->devices()
            ->where('device', $data['device'])
            ->exists();
        // Check if device is new and if first
        if( !$isDeviceSaved ){
            $user->devices()->create($data);

            if($user->devices()->count() > 1){
                $emailData = array_merge($data, ['email' => $user->email]);
                Mail::to($user)->queue(new NewDeviceSignIn($emailData));
            }
        }
    }
}
