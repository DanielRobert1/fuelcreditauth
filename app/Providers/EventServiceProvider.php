<?php

namespace App\Providers;

use App\Events\Auth\Authenticated;
use App\Listeners\Auth\SendWelcomeMail;
use App\Listeners\Auth\StoreLoginActivity;
use App\Listeners\Auth\UpdateAllUserLoginActivity;
use App\Listeners\Auth\UpdateLoginActivity;
use App\Listeners\Auth\UpdateNewDevice;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            SendWelcomeMail::class,
        ],
        Authenticated::class => [
            StoreLoginActivity::class,
            UpdateNewDevice::class,
        ],
        SignedOut::class => [
            UpdateLoginActivity::class,
        ],
        SignedOutAllDevices::class => [
            UpdateAllUserLoginActivity::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
