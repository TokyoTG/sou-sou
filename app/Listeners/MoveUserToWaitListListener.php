<?php

namespace App\Listeners;

use App\Providers\MoveUserToWaitListEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\GroupUser;

use App\Group;
use App\User;
use App\WaitList;



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
        try{
            $users = $event->user;
            $position = count(WaitList::all()) + 1;
            foreach($users as $user){
             GroupUser::where('user_id',$user['user_id'])->delete();
            Group::where('id', $user['group_id'])->decrement('members_number');
            $user_to_wait_list = new WaitList();
            $user_to_wait_list->user_id = $user['user_id'];
            $user_to_wait_list->user_name = $user['user_name'];
            $user_to_wait_list->user_email = $user['user_email'];
            $user_to_wait_list->position = $position;
            $user_to_wait_list->save(); 
            }
         
        }catch(\Exception $e){
           dd('something went wrong sending user back to waitlist');
        }
       
    }
}
