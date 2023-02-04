<?php

namespace App\Events\Auth;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $password;

    /**
     * NewRegistered constructor.
     * @param Model $user
     * @param string $password
     */
    public function __construct(Model $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
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
