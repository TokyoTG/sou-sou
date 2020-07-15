<?php

namespace App\Http\Controllers;

use App\GroupUser;
use Illuminate\Http\Request;

use App\WaitList;

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

        $group_id = $request->input('group_id');
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
                    return redirect()->route('wait_list.show',$group_id);
                }
            } else {
                    try{

                        $group_user = new GroupUser();
                        $group_user->group_id = $group_id;
                        $group_user->user_id = $request->input('user_id');
                        $group_user->group_name = $request->input('group_name');
                        $group_user->status = "active";
                        $group_user->user_level = $request->input('user_level');
                        $group_user->save();
                        $wait_list = WaitList::where('group_id', $group_id)->where('user_id',$request->input('user_id'))->get(['id']);
                        if(count($wait_list) > 0){
                            WaitList::destroy($wait_list->toArray());
                        }
                        $request->session()->flash('alert-class', 'alert-success');
                        $request->session()->flash('message', "User added successfully");
                        return redirect()->route('wait_list.show',$group_id);
                    }catch(\Exception $e){
                        $request->session()->flash('alert-class', 'alert-danger');
                        $request->session()->flash('message',"Something went wrong with your request, please try again");
                        return redirect()->route('wait_list.show',$group_id);
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
    public function destroy($id)
    {
        //
    }
}
