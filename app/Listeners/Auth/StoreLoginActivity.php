<?php

namespace App\Listeners\Auth;

use App\Events\Auth\Authenticated;
use App\Models\LoginHistory;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreLoginActivity implements ShouldQueue
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
     * @param Authenticated $event
     * @return void
     */
    public function handle(Authenticated $event): void
    {
        $this->loginHistory->createLoginHistory($event->user->id, $event->requestData);
    }
}
