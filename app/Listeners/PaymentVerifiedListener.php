<?php

namespace App\Listeners;

use App\Providers\PaymentVerifiedEvent;
use App\Providers\AddedToGroupMailEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\GroupUser;

use App\Notification;

use App\Group;
use App\Providers\CheckWaitListEvent;
use App\User;
use App\Platform;

class PaymentVerifiedListener
{
    public $new_group_id;
    public function handle(PaymentVerifiedEvent $event)
    {
        //
        // dd('a payment is verified');
        $platform = Platform::first();
        if($platform->status){
            $group_id = $event->group_id;
            $email_arrays =array();
            $num_of_completed = GroupUser::where('group_id',$group_id)->where('task_status','completed')->count();
            if($num_of_completed == 15){

                try{
                        //remove water
                // $water_id = GroupUser::where('group_id', $group_id)->where('user_level',"water")->get(['id']);
                    GroupUser::where('group_id', $group_id)->where('user_level',"water")->delete();


                    //split earth and create new group
                    $earths = GroupUser::where('group_id', $group_id)->where('user_level',"earth")->take(1)->first();
                    //$new_water_user = User::find($earths->user_id);

                    $new_group_name = $earths->group_name ."_splittedHalf";
                    $new_group = new Group();
                    $new_group->name = $new_group_name;
                    $new_group->status = "open";
                    $new_group->members_number = 7;
                    $new_group->save();

                    $this->new_group_id = $new_group->id;

                    GroupUser::destroy($earths->id);

                    $this->addUsertoGroup($earths,$new_group_name,"water",$this->new_group_id);
                    User::where('id',$earths->user_id)->increment('top_times');
                    User::where('id',$earths->user_id)->increment('group_times');
                    
                    

                    //split and delete Earth 
                    $winds = GroupUser::where('group_id', $group_id)->where('user_level',"wind")->take(2)->get();
                    foreach($winds as $wind_member){
                        array_push($email_arrays,$wind_member->user_email);

                        GroupUser::destroy($wind_member->id);
                        User::where('id',$wind_member->user_id)->increment('group_times');

                        $this->addUsertoGroup($wind_member,$new_group_name,"earth",$this->new_group_id);
                    }

                    //split and delete fires 
                    $fires = GroupUser::where('group_id', $group_id)->where('user_level',"fire")->take(4)->get();
                    foreach($fires as $fire_member){

                        GroupUser::destroy($fire_member->id);
                        User::where('id',$fire_member->user_id)->increment('group_times');
                        
                        array_push($email_arrays,$fire_member->user_email);
                        $this->addUsertoGroup($fire_member,$new_group_name,"wind",$this->new_group_id);
                    }

                    //assign proper number of member for both group
                    Group::where('name',$earths->group_name)->update(['members_number' => 7, 'status'=> "open"]);

                    //updates former group
                    GroupUser::where('group_id', $group_id)->where('user_level',"earth")->update(['user_level' => 'water']);
                    GroupUser::where('group_id', $group_id)->where('user_level',"wind")->update(['user_level' => 'earth','task_status'=>'uncompleted']);
                    GroupUser::where('group_id', $group_id)->where('user_level',"fire")->update(['user_level' => 'wind','task_status'=>'uncompleted']);
                    // dd("split will happen");

                    //sends message to all users in the former group
                    
                $former_earths = GroupUser::where('group_id', $group_id)->where('user_level',"earth")->get();
                $former_wind = GroupUser::where('group_id', $group_id)->where('user_level',"wind")->get();
                $former_group_water = GroupUser::where('group_id', $group_id)->where('user_level',"water")->first();
                //$former_water_user = User::find($former_group_water->user_id);
                
                User::where('id',$former_group_water->user_id)->increment('top_times');
                User::where('id',$former_group_water->user_id)->increment('group_times');

                foreach($former_earths as $former_earth){
                    array_push($email_arrays,$former_earth->user_email);
                    User::where('id',$former_earth->user_id)->increment('group_times');
                }

                foreach($former_wind as $former_earth){
                    array_push($email_arrays,$former_earth->user_email);
                    User::where('id',$former_earth->user_id)->increment('group_times');
                }


                $notifications = Notification::where('group_id', $group_id)->get(['id']);
                if(count($notifications) > 0){
                    Notification::destroy($notifications->toArray());
                }

                
                event(new CheckWaitListEvent());
                event(new AddedToGroupMailEvent($email_arrays));
        
                } catch(\Exception $e){
                    if ($e->getCode() == 23000) {
                        // Deal with duplicate key error  
                    // dd('some duplicate key error');
                    }
                }
                
            }
        }
        return redirect()->route('dashboard.index');
    }

    public function addUsertoGroup($object, $group_name, $user_level,$group_id){
        $group_user = new GroupUser();
        $group_user->user_id = $object->user_id;
        $group_user->user_name = $object->user_name;
        $group_user->group_id = $group_id;
        $group_user->user_email = $object->user_email;
        $group_user->group_name = $group_name;
        $group_user->user_level = $user_level;
        $group_user->task_status = "completed";
        $group_user->save();
    }


    // public function groupMessageDispatcher($group_id,$user,$top_user,$group_name){
    //     $new_task = new Notification();
    //     $new_task->group_id = $group_id;
    //     $new_task->verified = false;
    //     $new_task->is_read = false;
    //     $new_task->title = "Bless Top User";
    //     $new_task->completed = false;
    //     $new_task->user_id = $user->user_id;
    //     $new_task->user_name = $user->user_name;
    //     $new_task->message = "Hello {$user->user_name} You are required to bless {$top_user->full_name} an amount of #1000 the top ranked person in the {$group_name} group with the following details: \n Account Number: {$top_user->account_number}  \n Bank Name : {$top_user->bank_name} .\n This should be done within 1 hour after recieving this message.  \n Signed YBA Admin";
    //     $new_task->save();
    // }
}
