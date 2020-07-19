<?php

namespace App\Listeners;

use App\Providers\PaymentVerifiedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\GroupUser;

use App\Notification;

use App\Group;

use App\User;

class PaymentVerifiedListener
{
    public $new_group_id;
    public function handle(PaymentVerifiedEvent $event)
    {
        //
        // dd('a payment is verified');
        $group_id = $event->group_id;
        $num_of_completed = GroupUser::where('group_id',$group_id)->where('task_status','completed')->count();
        if($num_of_completed == 15){

            try{
                    //remove flower
                $flower_id = GroupUser::where('group_id', $group_id)->where('user_level',"flower")->get(['id']);
                GroupUser::where('group_id', $group_id)->where('user_level',"flower")->delete();


                //split water and create new group
                $waters = GroupUser::where('group_id', $group_id)->where('user_level',"water")->take(1)->first();
                $new_flower_user = User::find($waters->user_id);
                $new_group_name = $waters->group_name ."_splittedHalf";
                $new_group = new Group();
                $new_group->name = $new_group_name;
                $new_group->status = "open";
                $new_group->members_number = 7;
                $new_group->save();

                $this->new_group_id = $new_group->id;

                GroupUser::destroy($waters->id);

                $this->addUsertoGroup($waters,$new_group_name,"flower",$this->new_group_id);
                
                
                

                //split and delete Earth 
                $earths = GroupUser::where('group_id', $group_id)->where('user_level',"earth")->take(2)->get();
                foreach($earths as $earth_member){
                    GroupUser::destroy($earth_member->id);
                    $this->addUsertoGroup($earth_member,$new_group_name,"water",$this->new_group_id);
                    $this->groupMessageDispatcher($this->new_group_id,$earth_member,$new_flower_user,$new_group_name);
                }

                //split and delete fires 
                $fires = GroupUser::where('group_id', $group_id)->where('user_level',"fire")->take(4)->get();
                foreach($fires as $fire_member){
                    GroupUser::destroy($fire_member->id);
                    $this->addUsertoGroup($fire_member,$new_group_name,"earth",$this->new_group_id);
                    $this->groupMessageDispatcher($this->new_group_id,$fire_member,$new_flower_user,$new_group_name);
                }

                 //assign proper number of member for both group
                Group::where('name',$waters->group_name)->update(['members_number' => 7]);

                //updates former group
                GroupUser::where('group_id', $group_id)->where('user_level',"water")->update(['user_level' => 'flower']);
                GroupUser::where('group_id', $group_id)->where('user_level',"earth")->update(['user_level' => 'water','task_status'=>'uncompleted']);
                GroupUser::where('group_id', $group_id)->where('user_level',"fire")->update(['user_level' => 'earth','task_status'=>'uncompleted']);
                // dd("split will happen");

                //sends message to all users in the former group
                
               $former_waters = GroupUser::where('group_id', $group_id)->where('user_level',"water")->get();
               $former_earth = GroupUser::where('group_id', $group_id)->where('user_level',"earth")->get();
               $former_group_flower = GroupUser::where('group_id', $group_id)->where('user_level',"flower")->first();
               $former_flower_user = User::find($former_group_flower->user_id);

               foreach($former_waters as $former_water){
                $this->groupMessageDispatcher($group_id,$former_water,$former_flower_user,$former_group_flower->group_name);
               }

               foreach($former_earth as $former_water){
                $this->groupMessageDispatcher($group_id,$former_water,$former_flower_user,$former_group_flower->group_name);
               }
    
            } catch(\Exception $e){
                if ($e->getCode() == 23000) {
                    // Deal with duplicate key error  
                dd('some duplicate key error');
                }
            }
            
        }
    }

    public function addUsertoGroup($object, $group_name, $user_level,$group_id){
        $group_user = new GroupUser();
        $group_user->user_id = $object->user_id;
        $group_user->user_name = $object->user_name;
        $group_user->group_id = $group_id;
        $group_user->group_name = $group_name;
        $group_user->user_level = $user_level;
        if($user_level != 'flower'){
            $group_user->task_status = "completed";
        }
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
        $new_task->message = "Hello {$user->user_name} You are required to bless {$top_user->full_name} an amount of #1000 the top ranked position in the {$group_name} group with the following details: \n Account Number: {$top_user->account_number}  \n Bank Name : {$top_user->bank_name} .\n This should be done within 1 hour after recieving this message.  \n Signed Sou Sou Admin";
        $new_task->save();
    }
}
