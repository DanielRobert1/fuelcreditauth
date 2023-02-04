<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAppConfigs();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         // Remove data wrap from json resource
         JsonResource::withoutWrapping();
    }

    private function registerAppConfigs(): void
    {
        // Set max length for mysql db
        Schema::defaultStringLength(191);

        // For https scheme if not on local machine
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
