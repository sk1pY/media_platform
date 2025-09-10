<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewSubscriber
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $subscriber;
    public  $subscribedTo;
    /**
     * Create a new event instance.
     */
    public function __construct(User $subscriber,User $subscribedTo)
    {
        $this->subscriber = $subscriber;
        $this->subscribedTo = $subscribedTo;
    }
}
