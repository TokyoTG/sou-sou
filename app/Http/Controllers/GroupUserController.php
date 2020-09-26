<?php

namespace App\Http\Controllers;

use App\GroupUser;
use Illuminate\Http\Request;

// use App\Events\UserAddedToGroupEvent;

use Illuminate\Support\Facades\Cookie;

use App\WaitList;

use App\Notification;

use App\Group;
use App\User;
use App\PaymentMethod;

use App\Providers\UserAddedToGroupEvent;
use App\Providers\AddedToGroupMailEvent;

use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class GroupUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // return print_r($request->input()); 
        $messages = [
            'required' => 'All input fields are required',
        ];
        if ($request->all()) {
            $validator = Validator::make($request->all(), [
                'user_level' => 'required',
            ], $messages);
            if ($validator->fails()) {
                $errors = $validator->errors();
                foreach ($errors->all() as $message) {
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', $message);
                    return redirect()->route('wait_list.index');
                }
            } else {
                try {

                    $group_name = $request->input('group_name');
                    $username = $request->input('user_name');
                    $level = $request->input('user_level');
                    $user_id = $request->input('user_id');
                    $user_email = $request->input('user_email');

                    $group = Group::where('name', $group_name)->first();
                    $group_id = $group->id;
                    $group_count = count($group->group_users);
                    $list_id = $request->input('list_id');

                    $group_user = new GroupUser();
                    $group_user->user_id = $request->input('user_id');
                    $group_user->group_id = $group_id;
                    $group_user->user_level = $level;
                    $request->session()->flash('alert-class', 'alert-danger');



                    if ($group_count <= 0 && $level != "water") {
                        $request->session()->flash('message', "Request denied, you cannot add another this level without adding the water level first");
                        return redirect()->route('wait_list.index');
                    }
                    if ($level == "water") {
                        $check_water = GroupUser::where('group_name', $group_name)->where('user_level', "water")->get('id');
                        if (count($check_water) > 0) {
                            $request->session()->flash('message', "Request denied, you cannot have more than 1 user at water level");
                            return redirect()->route('wait_list.index');
                        }


                        User::where('id', $user_id)->increment('top_times');
                        User::where('id', $user_id)->increment('group_times');
                        $group_user->task_status = "completed";
                        // return print_r($request->input());

                    } else {
                        $top_user_id = GroupUser::where('group_name', $group_name)->where('user_level', "water")->get('user_id')[0]->user_id;
                        $top_user = User::find($top_user_id);

                        if ($level == "earth") {
                            $check_earth = GroupUser::where('group_name', $group_name)->where('user_level', "earth")->get('id');
                            if (count($check_earth) >= 2) {
                                $request->session()->flash('message', "Request denied, you cannot have more than 2 user at earth level");
                                return redirect()->route('wait_list.index');
                            }
                            User::where('id', $user_id)->increment('group_times');
                            $group_user->task_status = "completed";
                        }

                        if ($level == "wind") {
                            $check_wind = GroupUser::where('group_name', $group_name)->where('user_level', "wind")->get('id');
                            if (count($check_wind) >= 4) {
                                $request->session()->flash('message', "Request denied, you cannot have more than 4 user at wind level");
                                return redirect()->route('wait_list.index');
                            }
                            User::where('id', $user_id)->increment('group_times');
                            $group_user->task_status = "completed";
                        }

                        if ($level == "fire") {

                            $check_fire = GroupUser::where('group_name', $group_name)->where('user_level', "fire")->get('id');
                            if (count($check_fire) >= 8) {
                                $request->session()->flash('message', "Request denied, you cannot have more than 8 user at fire level");
                                return redirect()->route('wait_list.index');
                            }
                            User::where('id', $user_id)->increment('group_times');
                            $group_user->task_status = "uncompleted";
                        }
                    }
                    $group_user->save();
                    if ($level == "fire") {
                        $this->addTask($username, $user_id, $group_id, $group_user->id);
                    }

                    $event_data = [
                        'user_id' => $user_id,
                        'group_name' => $group_name
                    ];
                    event(new UserAddedToGroupEvent($event_data));


                    $members_count = GroupUser::where('group_id', $group_id)->count();
                    Group::where('name', $group_name)->update(['members_number' => $members_count]);

                    $wait_list = WaitList::find($list_id);
                    $wait_list->delete();

                    $emails = array();
                    array_push($emails, $user_email);
                    event(new AddedToGroupMailEvent($emails));
                    $request->session()->flash('alert-class', 'alert-success');
                    $request->session()->flash('message', "User added successfully");
                    return redirect()->route('wait_list.index');
                } catch (\Exception $e) {
                    if ($e->getCode() == 23000) {
                        $request->session()->flash('alert-class', 'alert-danger');
                        $request->session()->flash('message', "User already exists in a flower");
                        return redirect()->route('wait_list.index');
                    }
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', "Something went wrong with your request, please try again");
                    return redirect()->route('wait_list.index');
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        // return print_r($request->input());
        try {
            // $user_id =  $request->input('user_id');
            // $group_name = $request->input('group_name');
            $group_user = GroupUser::find($id);
            $group_id = $request->input('group_id');
            $group_user->delete();
            $request->session()->flash('alert-class', 'alert-success');
            $request->session()->flash('message', "User was successfully removed from the flower");
            return redirect()->route('flowers.show', $group_id);
        } catch (\Exception $e) {
            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message', "Something went wrong with your request, please try again");
            return redirect()->route('flowers.show', $group_id);
        }
    }


    public function addTask($username, $user_id, $group_id, $group_user_id)
    {
        $new_task = new Notification();
        $new_task->group_id = $group_id;
        $new_task->verified = false;
        $new_task->group_user_id = $group_user_id;
        $new_task->title = "TIme to Bless the Water!";
        $new_task->is_read = false;
        $new_task->completed = false;
        $new_task->user_name = $username;
        $new_task->user_id = $user_id;
        $new_task->save();
    }
}
