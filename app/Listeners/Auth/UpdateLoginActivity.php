<?php

namespace App\Listeners\Auth;

use App\Events\Auth\SignedOut;
use App\Models\LoginHistory;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateLoginActivity implements ShouldQueue
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
     * @param SignedOut $event
     * @return void
     */
    public function handle(SignedOut $event): void
    {
        $this->loginHistory->updateLoginHistory($event->user->id, $event->requestData);
    }
}
