<?php

namespace App\Listeners;

use App\Providers\PopulateGroupEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Group;
use App\GroupUser;
use App\Notification;
use App\User;
use App\WaitList;

class PopulateGroupListener
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
     * @param  PopulateGroupEvent  $event
     * @return void
     */
    public function handle(PopulateGroupEvent $event)
    {
        //
        $new_members = $event->members_to_add;
        $new_group_name = $this->generateGroupName();
        $new_group = new Group();
        $new_group->name = $new_group_name;
        $new_group->status = 'closed';
        $new_group->members_number = 15;
        $new_group->save();
        $new_group_id = $new_group->id;

        //counters
        $general_count = 0;

        foreach($new_members as $new_member){
            if( $general_count < 1){
                //add user as water
                $top_user_id = $new_member->user_id;
                $top_user = User::find($top_user_id);
                $this->addUsertoGroup($new_member,$new_group_name,'water',$new_group_id);
            }
            if($general_count < 3 ){
                //add user as earth
                $this->addUsertoGroup($new_member,$new_group_name,'earth',$new_group_id);
                $this->groupMessageDispatcher($new_group_id,$new_member,$top_user,$new_group_name);
            }
            if( $general_count < 7){
                //add user as air
                $this->addUsertoGroup($new_member,$new_group_name,'air',$new_group_id);
                $this->groupMessageDispatcher($new_group_id,$new_member,$top_user,$new_group_name);
            }
            if($general_count < 15){
                //add user as fire
                $this->addUsertoGroup($new_member,$new_group_name,'fire',$new_group_id);
                $this->groupMessageDispatcher($new_group_id,$new_member,$top_user,$new_group_name);
            }
            $general_count++;
            WaitList::where('user_id',$new_member->user_id)->delete();
        }
        

    }


    public function addUsertoGroup($object, $group_name, $user_level,$group_id){
        $group_user = new GroupUser();
        $group_user->user_id = $object->user_id;
        $group_user->user_name = $object->user_name;
        $group_user->group_id = $group_id;
        $group_user->group_name = $group_name;
        $group_user->user_level = $user_level;
        $group_user->task_status = "uncompleted";
        if($user_level == 'water'){
            $group_user->task_status = "completed";
        }
        $group_user->save();
    }


    public function groupMessageDispatcher($group_id,$user,$top_user,$group_name){
        $new_task = new Notification();
        $new_task->group_id = $group_id;
        $new_task->verified = false;
        $new_task->is_read = false;
        $new_task->title = "Bless Top User";
        $new_task->completed = false;
        $new_task->user_id = $user->user_id;
        $new_task->user_name = $user->user_name;
        $new_task->message = "Hello {$user->user_name} You are required to bless {$top_user->full_name} an amount of #1000 the top ranked person in the {$group_name} group with the following details: \n Account Number: {$top_user->account_number}  \n Bank Name : {$top_user->bank_name} .\n This should be done within 1 hour after recieving this message.  \n Signed Sou Sou Admin";
        $new_task->save();
    }

    public function generateGroupName(){
        $name = "";
        $alphabets = ['a', 'b', 'A', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'i', 'I', 'j', 'm', "M", 'y', 'z', 'w', 'Z'];

        for ($i = 0; $i < 7; $i++) {
            $index = mt_rand(0, count($alphabets) - 1);
            $name .= $alphabets[$index];
        }
        return $name;
    }
}
