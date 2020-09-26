<?php

namespace App\Listeners;

use App\Providers\PopulateOldGroupEvent;
use App\Providers\AddedToGroupMailEvent;
use App\Providers\CheckWaitListEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\GroupUser;
use App\Notification;
use App\PaymentMethod;
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
        if ($platform->status) {


            $email_arrays = array();
            $new_members  = $event->data['new_members'];
            $group = $event->data['group_info'];

            $top_user = GroupUser::where('group_id', $group['id'])->where('user_level', 'water')->first();
            // $top_user_info = User::find($top_user->user_id);
            // $top_user_details = $this->paymentDetails($top_user->user_id);

            foreach ($new_members as $new_member) {
                $group_user =  $this->addUsertoGroup($new_member->user_id, 'fire', $group['id']);
                $this->groupMessageDispatcher($group['id'], $new_member, $group_user->id);
                array_push($email_arrays, $new_member->user_email);
                User::where('id', $new_member->user_id)->increment('group_times');

                $item = WaitList::find($new_member->id);
                $item->delete();
            }


            Group::where('id', $group['id'])->update(['status' => 'closed']);
            event(new AddedToGroupMailEvent($email_arrays));
            event(new CheckWaitListEvent());
        }
        // return redirect()->route('dashboard.index');
    }

    public function addUsertoGroup($user_id,  $user_level, $group_id)
    {
        $group_user = new GroupUser();
        $group_user->user_id = $user_id;
        $group_user->group_id = $group_id;
        $group_user->user_level = $user_level;
        $group_user->task_status = "uncompleted";
        $group_user->save();
        return $group_user;
    }


    public function groupMessageDispatcher($group_id, $user, $group_user_id)
    {
        $new_task = new Notification();
        $new_task->group_id = $group_id;
        $new_task->verified = false;
        $new_task->group_user_id = $group_user_id;
        $new_task->is_read = false;
        $new_task->title = "TIme to Bless the Water!";
        $new_task->completed = false;
        $new_task->user_id = $user->user_id;
        $new_task->user_name = $user->user->full_name;
        // $new_task->message = "Hello {$user->user_name}, In order to keep your fire 
        // position you are required to bless the water on the {$group_name} flower. 
        // The person to send your gift to is {$top_user['user_name']}. Here are the 
        // preferred methods of receiving gifts: \n {$top_user['payment_details']} .
        //  \n You have 1 hour to send your gift using any of the listed methods. \n Signed,YBA Admin.";

        $new_task->save();
    }


    public function paymentDetails($top_user_id)
    {
        $methods = PaymentMethod::where('user_id', $top_user_id)->get();
        $top_user_name = "";
        $payment_methods = '';
        foreach ($methods as $index => $method) {
            ++$index;
            $payment_methods .= "(" . $index . ")." .  "\n Name: " . $method->platform . " " . " $method->platform-Details: " .  $method->details . "\n" . " " . " $method->platform-Contacts: " . $method->contact . " \n";
            $top_user_name = $method->user_name;
        }
        $data = [
            'payment_details' => $payment_methods,
            'user_name' => $top_user_name
        ];
        return $data;
    }
}
