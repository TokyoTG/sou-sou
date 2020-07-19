<?php

namespace App\Http\Controllers;

use App\GroupUser;
use Illuminate\Http\Request;

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
        foreach($tasks as $task){
            $now = time(); 
            $your_date = strtotime($task->created_at);
            $datediff =60 - round(($now - $your_date) / 60);
            if($datediff < 0 ){
                $to_delete = Notification::find($task->id);
                if(!$task->verified && !$task->completed){
                    //move user ot wait list when task is not verified
                    $to_delete->delete();
                    $user_data = [
                        'user_id' => $user_id,
                        'user_name' => $user_name,
                        'group_id' => $task->group_id
                    ];
                    event(new MoveUserToWaitListEvent($user_data));
               }
            }
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
        return view('dashboard.single_task')->with('task',$task);
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
            $request_type = $request->input('request');
            $time_left = intval($request->input('time_left'));
            if($request_type == "completion"){
                // return $time_left;
                if($time_left >= 0){
                     $task->completed = true;
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
                GroupUser::where('group_id',$group_id)->where('user_id',$user_id)->update(['task_status'=> 'completed']);
                // return $user_id;
                event(new PaymentVerifiedEvent($group_id));
                $task->verified = true;
                $task->save();
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
