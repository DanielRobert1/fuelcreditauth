<?php

namespace App\Listeners\Auth;

use App\Events\Auth\SignedOutAllDevices;
use App\Models\LoginHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateAllUserLoginActivity implements ShouldQueue
{
    private $loginHistory;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(LoginHistory $loginHistory)
    {
        $this->loginHistory = $loginHistory;
    }

    /**
     * Handle the event.
     *
     * @param SignedOutAllDevices $event
     * @return void
     */
    public function handle(SignedOutAllDevices $event)
    {
        $this->loginHistory->updateAllOpenLoginHistory($event->user->id, $event->signedOutAt);
    }
}
