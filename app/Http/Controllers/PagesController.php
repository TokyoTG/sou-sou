<?php

namespace App\Http\Controllers;

use App\GroupUser;

use App\User;

use App\WaitList;

use App\Notification;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cookie;

class PagesController extends Controller
{
    //
    public function dashboard(){
        $show_buttun = false;
        $user_id =  Cookie::get('id');
        $user = User::find($user_id);
        if($user->groups_in > 0){
            return view('dashboard.index')->with('show_button',$show_buttun);
        }   
        $check_wait_list =   WaitList::where('user_id',$user_id)->get('id');
        if(count($check_wait_list) >=  4){
            return view('dashboard.index')->with('show_button',$show_buttun);
        }else{
            $show_buttun = true;
            return view('dashboard.index')->with('show_button',$show_buttun);
        }
        
    }

    public function payments(){
        $user_id =  Cookie::get('id');
        $users_in_group = [];
        $group_in = Notification::where('user_id', $user_id)->get();
        if(count($group_in) > 0){
            if($group_in[0]->user_level == 'flower'){
                $group_id = $group_in[0]->group_id;
                $users_in_group = GroupUser::where('group_id',$group_id)->where('task_status',"completed")->get();
            }
        }
        // return $users_in_group;
        return view('dashboard.verify_payments')->with('pay_data', $users_in_group);
    }

    
}
