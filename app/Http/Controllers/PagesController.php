<?php

namespace App\Http\Controllers;

use App\GroupUser;
use App\User;
use App\WaitList;
use App\Group;

use App\Notification;
use App\Platform;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cookie;

class PagesController extends Controller
{
    //
    public function dashboard(){
        $show_buttun = false;
        $user_id =  Cookie::get('id');
        if(Cookie::get('role') !== null && Cookie::get('role') == "member"){
             $count_wait_list =   WaitList::where('user_id',$user_id)->count();
             $group = GroupUser::where('user_id',$user_id)->first();
             $is_top = GroupUser::where('user_id',$user_id)->where('user_level','water')->get('group_id');
             if(count($is_top) > 0){
                 $group_id = $is_top[0]->group_id;
                 $payments = Notification::where('completed',true)->where('verified',false)->where('group_id',$group_id)->count();
             }
             $member = [
                'list' => $count_wait_list,
                'payments' => isset($payments) ? $payments : "None",
                'show_btn' =>$show_buttun,
                'groups' => isset($group->group_name) ?  $group->group_name : "None",
                "user_level" => isset($group->user_level) ?  $group->user_level : false
            ];
            if($count_wait_list >=  4){
                return view('dashboard.index')->with('member',$member);
            }else{
              
                $member['show_btn'] = true;
            return view('dashboard.index')->with('member',$member);
            }

            
        }
       
        if(Cookie::get('role') !== null && Cookie::get('role') == "admin"){
            $count_users = User::where('role','member')->count();
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
            if($group_in->user_level == 'water'){
                $group_id = $group_in->group_id;
                $users_in_group = Notification::where('group_id',$group_id)
                ->where('completed',true)->get();
            }
        }
        // return $users_in_group;
        return view('dashboard.verify_payments')->with('pay_data', $users_in_group);
    }

    public function platform(Request $request){
        
        try{
            $status = $request->input('platform_status');
            $id = $request->input('platform_id');
            $user_id = $request->input('user_id');
            $platform = Platform::find($id);
        
            if($status){
                $platform->status = true; 
            }else{
                $platform->status = false;
            }
        
            $platform->save();
            $request->session()->flash('alert-class', 'alert-success');
            $request->session()->flash('message', "Platform status updated successfully");
            return redirect()->route('users.edit',$user_id); 
        } catch(\Exception $e){
            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message',"Something went wrong with your request, please try again");
            return redirect()->route('users.edit',$user_id);
        }
        
    }
    
}
