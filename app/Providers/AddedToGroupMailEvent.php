<?php

namespace App\Providers;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddedToGroupMailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $emails;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($emails)
    {
        //
        $this->emails = $emails;
    }

  
}
