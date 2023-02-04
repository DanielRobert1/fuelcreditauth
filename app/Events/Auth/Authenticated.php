<?php

namespace App\Events\Auth;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Authenticated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $requestData;

    /**
     * Authenticated constructor.
     * @param Model $user
     * @param array $requestData
     */
    public function __construct(Model $user, array $requestData)
    {
        $this->user = $user;
        $this->requestData = $requestData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
