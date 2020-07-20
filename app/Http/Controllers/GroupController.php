<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cookie;

use App\Group;
use App\Notification;
use App\User;
use App\GroupUser;

use App\WaitList;

use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{

    public function __construct()
    {
        $this->groups = [];
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        if(Cookie::get('role') !== null && Cookie::get('role') == "admin"){
            $this->groups = Group::all();
        }
        if(Cookie::get('role') !== null && Cookie::get('role') == "member"){
            $user_id = Cookie::get('id');
            $this->groups = GroupUser::where('user_id', $user_id)->get();
        }
        // return $this->groups;
        return view('dashboard.groups')->with('groups', $this->groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        
        $messages = [
            'required' => 'All input fields are required',
            "min" => "Group name can not be  less than 3 in length",
            "max" => "Group name can not be  greater than 16 in length",
        ];
        if ($request->all()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|alpha|min:3|max:16',
            ], $messages);
            if ($validator->fails()) {
                $errors = $validator->errors();
                foreach ($errors->all() as $message) {
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', $message);
                    return redirect()->route('groups.index');
                }
            } else {
                try{
                    $group = new Group();
                    $group->name = $request->input('name');
                    $group->status =  "open";
                    $group->members_number = 0;
                    $saved =  $group->save();
                  if($saved){
                        $request->session()->flash('alert-class', 'alert-success');
                        $request->session()->flash('message', "Group created successfully");
                        return redirect()->route('groups.index');
                    }else{
                          $request->session()->flash('alert-class', 'alert-danger');
                        $request->session()->flash('message', "Something bad happened, try again");
                        return redirect()->route('groups.index');
                    }
                  
                }catch(\Exception $e){
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', "Something bad happened, try again");
                    return redirect()->route('groups.index');
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $group_name = Group::find($id)->name;
        $members = GroupUser::where('group_name', $group_name)->get();
        $tasks = Notification::where('group_id',$id)->where('completed',false)->where('verified',false)->get();
        foreach($tasks as $task){
            $now = time(); 
            $your_date = strtotime($task->created_at);
            $datediff =60 - round(($now - $your_date) / 60);
            if($datediff < 0 ){

                //removing user from group, deleting notification and reducing the number of people in the group
                GroupUser::where('user_id',$task->user_id)->delete();
                Notification::where('user_id',$task->user_id)->delete();
                Group::where('id', $id)->decrement('members_number');

                $position = count(WaitList::all()) + 1;
                $user = User::find($task->user_id);
                $add_new = new WaitList();
                $add_new->user_id = $task->user_id;
                $add_new->user_name = $user->full_name;
                $add_new->position = $position;
                $add_new->save();
            }
        }
        // return $members;
        return view('dashboard.singleGroup')->with('members',$members);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
      
        try{
            $group =Group::find($id);
            $group->status = $request->input('group_status');
            $saved =  $group->save();
          if($saved){
            $request->session()->flash('alert-class', 'alert-success');
            $request->session()->flash('message', "Group {$request->input('group_status')} successfully");
            return redirect()->route('groups.index');
          }
        }catch(\Exception $e){
            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message', "Something went wrong with you request, please try again");
            return redirect()->route('groups.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //
        try{
        $group = Group::find($id);
        $group_users = GroupUser::where('group_id', $id)->get(['id']);
        if($group != null){
              $group->delete();
        }
        if(count($group_users) > 0){
            GroupUser::destroy($group_users->toArray());
        }
        
        
        $request->session()->flash('alert-class', 'alert-success');
        $request->session()->flash('message', "Group and associated data has been deleted successfully");
        return redirect()->route('groups.index');
        }catch(\Exception $e){
            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message', "Something bad happened, try again");
            return redirect()->route('groups.index');
        }
       
    }

    public function show_user_list(){
        $user_id = Cookie::get('id');
        $user_list  = WaitList::where('user_id',$user_id)->get();
        // return $user_list;
        return view('dashboard.user_list')->with('user_list', $user_list);
    }
}
