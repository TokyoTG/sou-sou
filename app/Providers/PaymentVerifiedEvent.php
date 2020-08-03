<?php

namespace App\Providers;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentVerifiedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $group_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($group_id)
    {
        //
        $this->group_id = $group_id;
    }
}
