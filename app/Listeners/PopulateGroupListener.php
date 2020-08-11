<?php

namespace App\Listeners;

use App\Providers\PopulateGroupEvent;
use App\Providers\AddedToGroupMailEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Group;
use App\Platform;
use App\GroupUser;
use App\PaymentMethod;
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
        // dd('we got here');

        $platform = Platform::first();
        // return  "hi";
        if($platform->status){
            // return  "hi";
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
            $water_count = 0;

            $email_arrays =array();

            foreach($new_members as $new_member){
                if( $general_count < 1 && $water_count == 0){
                    //add user as water
                    $top_user_id = $new_member->user_id;
                    // $top_user = User::find($top_user_id);
                    // $top_user_details = $this->paymentDetails($top_user_id);
                    User::where('id',$top_user_id)->increment('top_times');
                    User::where('id',$top_user_id)->increment('group_times');
                    $this->addUsertoGroup($new_member,$new_group_name,'water',$new_group_id);
                    $water_count++;
                }
                if($general_count < 3 && $general_count > 0){
                    //add user as earth
                    User::where('id',$new_member->user_id)->increment('group_times');
                    $this->addUsertoGroup($new_member,$new_group_name,'earth',$new_group_id);
                
                }
                if( $general_count < 7 && $general_count > 2){
                    //add user as wind
                    User::where('id',$new_member->user_id)->increment('group_times');
                    $this->addUsertoGroup($new_member,$new_group_name,'wind',$new_group_id);
                
                }
                if($general_count < 15 && $general_count > 6 ){
                    //add user as fire
                    User::where('id',$new_member->user_id)->increment('group_times');
                    $this->addUsertoGroup($new_member,$new_group_name,'fire',$new_group_id);
                    $this->groupMessageDispatcher($new_group_id,$new_member);
            
                }
                $general_count++;
                array_push($email_arrays,$new_member->user_email);
                $item = WaitList::find($new_member->id);
                $item->delete();
            }
            
            event(new AddedToGroupMailEvent($email_arrays));
            return redirect()->route('dashboard.index');
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
        if($user_level == 'water' || $user_level == 'wind' || $user_level == 'earth'){
            $group_user->task_status = "completed";
        }
        $group_user->save();
    }


    public function groupMessageDispatcher($group_id,$user){
        $new_task = new Notification();
        $new_task->group_id = $group_id;
        $new_task->verified = false;
        $new_task->is_read = false;
        $new_task->title = "TIme to Bless the Water!";
        $new_task->completed = false;
        $new_task->user_id = $user->user_id;
        $new_task->user_name = $user->user_name;
        // $new_task->message = "Hello {$user->user_name}, In order to keep your 
        // fire position you are required to bless the water on the {$group_name} 
        // flower. The person to send your gift to is {$top_user['user_name']}. 
        // Here are the preferred methods of receiving gifts: \n {$top_user['payment_details']} . \n 
        // You have 1 hour to send your gift using any of the listed methods. \n Signed,YBA Admin.";
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
    public function paymentDetails ($top_user_id){
        $methods = PaymentMethod::where('user_id', $top_user_id)->get();
        $top_user_name = "";
        $payment_methods = '';
        foreach($methods as $index=>$method){
            ++$index;
           $payment_methods .="(". $index. ").".  "\n Name: ". $method->platform . " " ." $method->platform-Details: ".  $method->details ."\n". " "." $method->platform-Contacts: ". $method->contact ." \n";
           $top_user_name = $method->user_name;
        }
        $data = [
            'payment_details' => $payment_methods,
            'user_name' => $top_user_name
        ];
        return $data;
    }
}
