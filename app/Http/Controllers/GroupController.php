<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cookie;

use App\Group;

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
            $user_id =Cookie::get('id');
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
        $members = GroupUser::where('group_id', $id)->get();
        // return $members;
        return view('dashboard.singleGroup')->with('user',$members);
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
            // $e;
            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message', "Something bad happened, try again");
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
        $group_wait_list = WaitList::where('group_id', $id)->get(['id']);
        if($group != null){
              $group->delete();
        }
        if(count($group_users) > 0){
            GroupUser::destroy($group_users->toArray());
        }
        if(count($group_wait_list) > 0){
            WaitList::destroy($group_wait_list->toArray());
        }
        
        $request->session()->flash('alert-class', 'alert-success');
        $request->session()->flash('message', "Group and associated data deleted successfully");
        return redirect()->route('groups.index');
        }catch(\Exception $e){
            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message', "Something bad happened, try again");
            return redirect()->route('groups.index');
        }
       
    }

    public function show_join_group(){
        $this->groups = Group::all();
        return view('dashboard.join_group')->with('groups', $this->groups);
    }
}
