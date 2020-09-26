<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cookie;

use App\Group;
use App\Notification;
use App\User;
use App\GroupUser;

use App\Providers\PaymentVerifiedEvent;
use App\WaitList;

use App\Http\Resources\Group as GroupResource;
use App\Http\Resources\GroupCollection;

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

        if (Cookie::get('role') !== null && Cookie::get('role') == "admin") {
            $this->groups = Group::all();
            $this->groups = new GroupCollection($this->groups);
        }
        if (Cookie::get('role') !== null && Cookie::get('role') == "member") {
            $user_id = Cookie::get('id');
            $this->groups = GroupUser::where('user_id', $user_id)->get();
            // $this->groups = new GroupResource($this->group);
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
                'name' => 'required|min:3|max:16',
            ], $messages);
            if ($validator->fails()) {
                $errors = $validator->errors();
                foreach ($errors->all() as $message) {
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', $message);
                    return redirect()->route('flowers.index');
                }
            } else {
                try {
                    $group = new Group();
                    $group->name = $request->input('name');
                    $group->status =  "open";
                    $group->members_number = 0;
                    $saved =  $group->save();
                    if ($saved) {
                        $request->session()->flash('alert-class', 'alert-success');
                        $request->session()->flash('message', "Flower created successfully");
                        return redirect()->route('flowers.index');
                    } else {
                        $request->session()->flash('alert-class', 'alert-danger');
                        $request->session()->flash('message', "Something bad happened, try again");
                        return redirect()->route('flowers.index');
                    }
                } catch (\Exception $e) {
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', "Something bad happened, try again");
                    return redirect()->route('flowers.index');
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
    public function show(Request $request, $id)
    {
        //
        // $group_name = Group::find($id);
        // return new GroupResource($group_name);
        try {
            $group = Group::find($id);
            $members = $group->group_users;
            $tasks = Notification::where('group_id', $id)->where('completed', false)->where('verified', false)->get();
            $can_view = $this->can_view_group_user(Cookie::get('id'));
            foreach ($tasks as $task) {
                $now = time();
                $your_date = strtotime($task->created_at);
                $datediff = 180 - round(($now - $your_date) / 60);
                if ($datediff < 0) {

                    //removing user from group, deleting notification and reducing the number of people in the group
                    GroupUser::where('id', $task->group_user_id)->delete();
                    Notification::where('user_id', $task->user_id)->delete();

                    $position = WaitList::count() + 1;
                    $user = User::find($task->user_id);
                    $add_new = new WaitList();
                    $add_new->user_id = $task->user_id;
                    $add_new->user_email = $user->email;
                    $add_new->user_name = $user->full_name;
                    $add_new->position = $position;
                    $add_new->save();
                    $count = WaitList::where('user_id', $task->user_id)->count();
                    WaitList::where('user_id', $task->user_id)->update(['frequency' => $count]);
                }
            }
            // return $members;
            return view('dashboard.singleGroup')->with(compact('members', 'can_view'));
        } catch (\Exception $e) {
            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message', "Something bad happened, try again");
            return redirect()->route('flowers.index');
        }
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

        if ($request->input('request') == 'rename') {
            $validator = Validator::make($request->all(), [
                'group_name' => 'required|min:3|max:16',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                foreach ($errors->all() as $message) {
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', $message);
                    return redirect()->route('flowers.index');
                }
            } else {
                try {
                    $group = Group::find($id);
                    $group->name = $request->input('group_name');
                    $saved =  $group->save();
                    GroupUser::where('group_id', $id)->update(['group_name' => $group->name]);
                    if ($saved) {
                        $request->session()->flash('alert-class', 'alert-success');
                        $request->session()->flash('message', "Flower renamed successfully");
                        return redirect()->route('flowers.index');
                    }
                } catch (\Exception $e) {
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', "Something went wrong with you request, please try again");
                    return redirect()->route('flowers.index');
                }
            }
        } elseif ($request->input('request') == 'status') {
            try {
                $group = Group::find($id);
                $group->status = $request->input('group_status');
                $saved =  $group->save();
                if ($saved) {
                    $request->session()->flash('alert-class', 'alert-success');
                    $request->session()->flash('message', "Flower {$request->input('group_status')} successfully");
                    return redirect()->route('flowers.index');
                }
            } catch (\Exception $e) {
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message', "Something went wrong with you request, please try again");
                return redirect()->route('flowers.index');
            }
        } elseif ($request->input('request') == 'split') {
            $num_of_memebers = GroupUser::where('group_id', $id)->count();
            if ($num_of_memebers == 15) {
                event(new PaymentVerifiedEvent($id));
                $request->session()->flash('alert-class', 'alert-success');
                $request->session()->flash('message', "Request successfully");
                return redirect()->route('flowers.index');
            } else {
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message', "Flower can not be split yet, members are not up to 15");
                return redirect()->route('flowers.index');
            }
        }
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
        try {
            $group = Group::find($id);
            $group_users = $group->group_users->pluck('id');
            $notifications = $group->notifications->pluck('id');
            if ($group != null) {
                $group->delete();
            }
            if (count($group_users) > 0) {
                GroupUser::destroy($group_users->toArray());
            }

            if (count($notifications) > 0) {
                Notification::destroy($notifications->toArray());
            }


            $request->session()->flash('alert-class', 'alert-success');
            $request->session()->flash('message', "Flower and associated data has been deleted successfully");
            return redirect()->route('flowers.index');
        } catch (\Exception $e) {
            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message', "Something bad happened, try again");
            return redirect()->route('flowers.index');
        }
    }

    public function show_user_list()
    {
        $user_id = Cookie::get('id');
        $user_list  = WaitList::where('user_id', $user_id)->get();
        return view('dashboard.user_list')->with('user_list', $user_list);
    }

    public function can_view_group_user($user_id)
    {
        $groups_in = GroupUser::where('user_id', $user_id)->get();

        foreach ($groups_in as $item) {
            if ($item->user_level == 'fire') {
                return false;
            }
        }
        return true;
    }
}
