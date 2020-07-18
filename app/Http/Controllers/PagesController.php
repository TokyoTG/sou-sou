<?php

namespace App\Http\Controllers;

use App\GroupUser;
use App\User;
use App\WaitList;
use App\Group;

use App\Notification;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cookie;

class PagesController extends Controller
{
    //
    public function dashboard(){
        $show_buttun = false;
        $user_id =  Cookie::get('id');
        // $user = User::find($user_id);
        if(Cookie::get('role') !== null && Cookie::get('role') == "member"){
             $count_wait_list =   WaitList::where('user_id',$user_id)->count();
            if($count_wait_list >=  4){
                return view('dashboard.index')->with('show_button',$show_buttun);
            }else{
                $show_buttun = true;
                return view('dashboard.index')->with('show_button',$show_buttun);
            }
        }
       
        if(Cookie::get('role') !== null && Cookie::get('role') == "admin"){
            $count_users = User::all()->count();
            $count_groups = Group::all()->count();
            $count_waitlist = WaitList::all()->count();
            $admin =[
                'users' => $count_users,
                'groups' =>  $count_groups,
                'list'  => $count_waitlist
            ];
            return view('dashboard.index')->with('admin',$admin);
        }
        
    }

    public function payments(){
        $user_id =  Cookie::get('id');
        $users_in_group = [];
        $group_in = GroupUser::where('user_id', $user_id)->first();
        if($group_in){
            if($group_in->user_level == 'flower'){
                $group_id = $group_in->group_id;
                $users_in_group = Notification::where('group_id',$group_id)
                ->where('completed',true)->get();
            }
        }
        // return $users_in_group;
        return view('dashboard.verify_payments')->with('pay_data', $users_in_group);
    }

    
}
