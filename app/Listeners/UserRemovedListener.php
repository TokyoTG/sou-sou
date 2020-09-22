<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Providers\AddedToGroupMailEvent;
use App\GroupUser;
use App\Notification;
use App\PaymentMethod;
use App\Group;
use App\User;
use App\Platform;
use App\WaitList;

class UserRemovedListener
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
        $count_of_users = count($event->total_users);
        $email_arrays =array();
        foreach($event->total_users  as $user){

            $user_on_wait_list = WaitList::orderBy('position','asc')->first();
            if($user_on_wait_list){
                $group = Group::find($user['group_id']);
                
                $group_user = $this->addToGroup($user_on_wait_list,$group->id,$group->name);
                array_push($email_arrays,$user_on_wait_list->user_email);

                User::where('id',$user_on_wait_list->user_id)->increment('group_times');

                $this->addTask($group->id,$user_on_wait_list,$group_user->id);
                
                //remove user from waitlist 
                $item = WaitList::find($user_on_wait_list->id);
                $item->delete();
            }
           
        }


        if(count($email_arrays) > 0){
            event(new AddedToGroupMailEvent($email_arrays));
        }
        
    }

    public function addToGroup($object,$group_id,$group_name){
        $group_user = new GroupUser();
        $group_user->user_id = $object->user_id;
        $group_user->user_name = $object->user_name;
        $group_user->user_email = $object->user_email;
        $group_user->group_id = $group_id;
        $group_user->group_name = $group_name;
        $group_user->user_level = 'fire';
        $group_user->task_status = "uncompleted";
        $group_user->save();
        return $group_user;
    }

    public function addTask($group_id,$user,$group_user_id){
        $new_task = new Notification();
        $new_task->group_id = $group_id;
        $new_task->verified = false;
        $new_task->group_user_id = $group_user_id;
        $new_task->is_read = false;
        $new_task->title = "TIme to Bless the Water!";
        $new_task->completed = false;
        $new_task->user_id = $user->user_id;
        $new_task->user_name = $user->user_name;
        $new_task->save();
    }
}