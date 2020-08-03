<?php

namespace App\Providers;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserAddedToGroupEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $event_data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($event_data)
    {
        //
        $this->event_data = $event_data;
    }
}
