<?php

namespace App\Providers;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PopulateGroupEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $members_to_add;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($members_to_add)
    {
        //
        $this->members_to_add = $members_to_add;
    }

}
