<?php

namespace App\Listeners;

use App\Providers\MoveUserToWaitListEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\GroupUser;

use App\Group;
use App\User;
use App\WaitList;
use App\Notification;
use App\Providers\UserRemovedEvent;


class MoveUserToWaitListListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MoveUserToWaitListEvent  $event
     * @return void
     */
    public function handle(MoveUserToWaitListEvent $event)
    {
        //
        try {
            $users = $event->user;
            $position = WaitList::count() + 1;
            foreach ($users as $user) {
                GroupUser::where('id', $user['group_user_id'])->delete();
               // Notification::where('group_user_id', $user['group_user_id'])->where('group_id', $user['group_id'])->delete();
                $user_to_wait_list = new WaitList();
                $user_to_wait_list->user_id = $user['user_id'];
                $user_to_wait_list->position = $position;
                $user_to_wait_list->save();
                $count = WaitList::where('user_id', $user['user_id'])->count();
                WaitList::where('user_id', $user['user_id'])->update(['frequency' => $count]);
            }

            event(new UserRemovedEvent($users));
        } catch (\Exception $e) {
            // dd('something went wrong sending user back to waitlist');
        }
    }
}
