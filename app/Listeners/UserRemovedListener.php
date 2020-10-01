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
use Exception;

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
        try{
            $email_arrays = array();
            $count = count($event->total_users);
            $users_on_wait_list = WaitList::orderBy('position', 'asc')->take($count)->get();
            foreach ($event->total_users  as $index=>$user) {
                if (isset($users_on_wait_list[$index])) {
                    $group_user = $this->addToGroup($users_on_wait_list[$index]->user_id, $user['group_id']);
                    array_push($email_arrays, $users_on_wait_list[$index]->user_email);
    
                    User::where('id', $users_on_wait_list[$index]->user_id)->increment('group_times');
    
                    $this->addTask($user['group_id'], $users_on_wait_list[$index], $group_user->id);
    
                    //remove user from waitlist 
                    $users_on_wait_list[$index]->delete();
                }
            }
    
    
            if (count($email_arrays) > 0) {
                event(new AddedToGroupMailEvent($email_arrays));
            }
        }catch(Exception $e){
            
        }
       
    }

    public function addToGroup($user_id, $group_id)
    {
        $group_user = new GroupUser();
        $group_user->user_id = $user_id;
        $group_user->group_id = $group_id;
        $group_user->user_level = 'fire';
        $group_user->task_status = "uncompleted";
        $group_user->save();
        return $group_user;
    }

    public function addTask($group_id, $user, $group_user_id)
    {
        $new_task = new Notification();
        $new_task->group_id = $group_id;
        $new_task->verified = false;
        $new_task->group_user_id = $group_user_id;
        $new_task->is_read = false;
        $new_task->title = "Time to Bless the Water!";
        $new_task->completed = false;
        $new_task->user_id = $user->user_id;
        $new_task->user_name = $user->user->full_name;
        $new_task->save();
    }
}
