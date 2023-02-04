<?php

namespace App\Events\Auth;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SignedOut
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $requestData;

    /**
     * SignedOut constructor.
     * @param User $user
     * @param array $requestData
     */
    public function __construct(User $user, array $requestData)
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
