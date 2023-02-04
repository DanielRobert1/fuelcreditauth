<?php

namespace App\Traits;

use Jenssegers\Agent\Agent;

trait NeedsDeviceAgent
{
    /**
     * @var Agent|null
     */
    private $agent = null;

    /**
     * Get an instance of agent
     *
     * @return Agent
     */
    final public function getAgent(): Agent
    {
        return $this->agent instanceof Agent ?
            $this->agent :
            new Agent();
    }

    /**
     * @return string
     */
    final public function getUserActiveDevice(): string
    {
        $agent = $this->getAgent();

        if ($agent->isRobot($agent->getUserAgent()) || $agent->deviceType() === 'robot') {
            return $agent->robot();
        }

        $device = $agent->device() ? $agent->device() : $agent->platform();
        $version = $agent->version($device);

        if($device){
            return rtrim("$device $version");
        }

        $browser = $agent->browser();

        return $browser ? $browser : UNKNOWN_DEVICE_TOKEN;
    }
}
