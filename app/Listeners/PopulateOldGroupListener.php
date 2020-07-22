<?php

namespace App\Listeners;

use App\Providers\PopulateOldGroupEvent;
use App\Providers\AddedToGroupMailEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\GroupUser;
use App\Notification;
use App\Group;
use App\User;
use App\Platform;
use App\WaitList;

class PopulateOldGroupListener
{
  

    /**
     * Handle the event.
     *
     * @param  PopulateOldGroupEvent  $event
     * @return void
     */
    public function handle(PopulateOldGroupEvent $event)
    {
        //
        $platform =  Platform::first();
        if($platform->status){


            $email_arrays =array();
            $new_members  = $event->data['new_members'];
            $group = $event->data['group_info'];
            
            $top_user = GroupUser::where('group_id',$group['id'])->where('user_level','water')->first();
            $top_user_info = User::find($top_user->user_id);

            foreach($new_members as $new_member){
                $this->addUsertoGroup($new_member,$group['name'],'fire',$group['id']);
                $this->groupMessageDispatcher($group['id'],$new_member,$top_user_info,$group['name']);
                array_push($email_arrays,$new_member->user_email);
                User::where('id',$new_member->user_id)->increment('group_times');
                WaitList::where('user_id',$new_member->user_id)->delete();
            }


            Group::where('id',$group['id'])->update(['status'=>'closed', "members_number" => 15]);
            event(new AddedToGroupMailEvent($email_arrays));
        }
        return redirect()->route('dashboard.index');
    }
    
    public function addUsertoGroup($object, $group_name, $user_level,$group_id){
        $group_user = new GroupUser();
        $group_user->user_id = $object->user_id;
        $group_user->user_name = $object->user_name;
        $group_user->user_email = $object->user_email;
        $group_user->group_id = $group_id;
        $group_user->group_name = $group_name;
        $group_user->user_level = $user_level;
        $group_user->task_status = "uncompleted";
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
    }
