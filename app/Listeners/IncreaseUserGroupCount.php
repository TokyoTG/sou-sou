<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cookie;
use App\User;

use App\Group;

class IncreaseUserGroupCount
{

    public function handle($event)
    {
        //
        $event_data = $event->event_data;
        // Group::where('name',$event_data['group_name'])->increment('members_number');
    }
}
