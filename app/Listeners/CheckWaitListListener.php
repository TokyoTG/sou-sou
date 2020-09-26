<?php

namespace App\Listeners;

use App\Providers\CheckWaitListEvent;
use App\Providers\PopulateOldGroupEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\WaitList;
use App\GroupUser;
use App\Group;


class CheckWaitListListener
{

    /**
     * Handle the event.
     *
     * @param  CheckWaitListEvent  $event
     * @return void
     */
    public function handle(CheckWaitListEvent $event)
    {
        //
        $wait_list = WaitList::orderBy('position', 'asc')->get();
        $unique_list = $wait_list->take(8);


        //check if there any group t be filled
        if (count($unique_list) >= 8) {
            $check_group = Group::where('status', 'open')->first();
            if ($check_group) {
                $num_group_users = count($check_group->group_users);
                if ($num_group_users == 7) {

                    $group_data = [
                        'name' => $check_group->name,
                        'id' => $check_group->id
                    ];
                    $data = [
                        'new_members' => $unique_list,
                        'group_info' => $group_data
                    ];
                    event(new PopulateOldGroupEvent($data));
                }
            }
        }
    }
}
