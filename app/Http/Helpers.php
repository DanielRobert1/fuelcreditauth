<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;

if( !function_exists('user') )
{
    /**
     * @param string $guard
     * @return Authenticatable|User|object|null
     */
    function user()
    {
        return request()->user();
    }
}

if( !function_exists('convertToBoolean') )
{
    /**
     * @param string|bool $data
     * @return bool
     */
    function convertToBoolean($data): bool
    {
        if(is_bool($data)) return $data;

        if($data === 'false') return false;

        return (bool)$data;
    }
}

if( !function_exists('isAuthenticated') )
{
    /**
     * @param string $guard
     * @return bool
     */
    function isAuthenticated(): bool
    {
        return auth()->check();
    }
}

if( !function_exists('carbonParse') )
{
    /**
     * @param string $dateTime
     * @param string|null $timezone
     * @return Carbon
     */
    function carbonParse(string $dateTime, string $timezone = null): Carbon
    {
        $instance = $timezone ?
            Carbon::parse($dateTime)->timezone($timezone) :
            Carbon::parse($dateTime);

        if (!$timezone && $instance->timezoneName !== DEFAULT_APP_TIMEZONE)
            $instance = $instance->timezone(DEFAULT_APP_TIMEZONE);

        return $instance;
    }
}

if( !function_exists('parseRequestTime') )
{
    /**
     * @param string $dateTime
     * @return Carbon
     */
    function parseRequestTime(string $dateTime): Carbon
    {
        $timezone = DEFAULT_APP_TIMEZONE;
        return Carbon::parse($dateTime)->timezone($timezone);
    }
}