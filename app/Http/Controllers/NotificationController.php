<?php

namespace App\Http\Controllers;

use App\GroupUser;
use Illuminate\Http\Request;
use App\User;
use App\PaymentMethod;

use App\Providers\PaymentVerifiedEvent;

use App\Notification;
use App\Providers\MoveUserToWaitListEvent;
use Illuminate\Support\Facades\Cookie;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user_id =  Cookie::get('id');
        $user_name =  Cookie::get('full_name');
        $tasks = Notification::where('user_id',$user_id)->get();
        $all_tasks = Notification::all();
        $users = array();
        foreach($all_tasks as $task){
            $now = time(); 
            $your_date = strtotime($task->created_at);
            $datediff =60 - round(($now - $your_date) / 60);
            if($datediff < 0 ){
               
                if(!$task->verified && !$task->completed){
                    //move user ot wait list when task is not verified
                    $to_delete = Notification::find($task->id);
                    $to_delete->delete();
                    $user = User::find($user_id);
                    $user_data = [
                        'user_id' => $user->id,
                        'user_name' => $user->full_name,
                        'group_id' => $task->group_id,
                        'user_email' => $user->email 
                    ];

                    array_push($users, $user_data);
                  
               }
            }
        }
        if(count($users) > 0){
             event(new MoveUserToWaitListEvent($users));
        }
       
        $tasks = Notification::where('user_id',$user_id)->get();
        return view('dashboard.notifications')->with('tasks',$tasks);

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
        $task = Notification::find($id);
        $user_id = Cookie::get('id');
        $task->is_read = true;
        $task->save();
        $tasks = Notification::where('user_id',$user_id)->where('is_read',false)->get();
        session(['tasks' => $tasks]);
        $top_user = GroupUser::where('group_id',$task->group_id)->where('user_level',"water")->first();
        $top_user_details = User::find($top_user->user_id);
        $gift_methods = PaymentMethod::where('user_id',$top_user->user_id)->get();
        $top_user_data =[
            'full_name' => $top_user_details->full_name,
            'gift_methods' => $gift_methods,
            'group_name' => $top_user->group_name
        ];

        return view('dashboard.single_task')->with('task',$task)->with('top_user_data',$top_user_data);
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
        // return print_r($request->input());
        try{
            $task = Notification::find($id);
            $user_id = Cookie::get('id');
            $request_type = $request->input('request');
            $time_left = intval($request->input('time_left'));
            if($request_type == "completion"){
                if($time_left >= 0){
                     $task->completed = true;
                     $task->is_read = true;
                     $tasks = Notification::where('user_id',$user_id)->where('is_read',false)->get();
                     session(['tasks' => $tasks]);
                     $request->session()->flash('message', "Task has been mark completed, wait for the to verify it");
                }else{
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message',"Sorry you have exceeded the amount of time required to finish the task");
                    return redirect()->route('tasks.index');
                }
            }
            $request->session()->flash('alert-class', 'alert-success');
            $task->save();
            if($request_type == "verification"){

                $user_id = $request->input('user_id');
                $group_id = $request->input('group_id');


                // GroupUser::where('group_id',$group_id)->where('user_id',$user_id)->update(['task_status'=> 'completed']);

              
                $task->verified = true;
                $task->save();


                $num_of_completed = Notification::where('group_id', $group_id)->where('verified',true)->count();
                // return $num_of_completed;
                if($num_of_completed == 8){
                   
                    event(new PaymentVerifiedEvent($group_id));
                }

            
                $request->session()->flash('message', "Task has been mark verified");
                return redirect()->route('payments');
            }
            
           
            return redirect()->route('tasks.index');
        }catch(\Exception $e){
                        $request->session()->flash('alert-class', 'alert-danger');
                        $request->session()->flash('message',"Something went wrong with your request, please try again");
                        return redirect()->route('tasks.index');
                }
        return $id;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
