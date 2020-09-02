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
            // $num_of_completed = Notification::where('group_id', $group_id)->where('verified',true)->count();
            // if($num_of_completed == 8){

                try{
                        //remove water
                // $water_id = GroupUser::where('group_id', $group_id)->where('user_level',"water")->get(['id']);
                    GroupUser::where('group_id', $group_id)->where('user_level',"water")->delete();


                    //split earth and create new group
                    $earths = GroupUser::where('group_id', $group_id)->where('user_level',"earth")->take(1)->first();
                    //$new_water_user = User::find($earths->user_id);

                    $new_group_name = $this->generateGroupName();
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
                    GroupUser::where('group_id', $group_id)->where('user_level',"wind")->update(['user_level' => 'earth','task_status'=>'completed']);
                    GroupUser::where('group_id', $group_id)->where('user_level',"fire")->update(['user_level' => 'wind','task_status'=>'completed']);
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

                }
                
            // }
        }
        // return redirect()->route('dashboard.index');
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
