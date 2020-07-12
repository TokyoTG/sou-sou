<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\WaitList;

use App\Group;

use Illuminate\Support\Facades\Cookie;

class WaitListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('dashboard.wait_list');
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
        $group_name = $request->input('group_name');
        $group_id = $request->input('group_id');
        try{
            $position = count(WaitList::All()) +1;
            $wait_list = new WaitList;
            $wait_list->group_id = $group_id;
            $wait_list->user_id = Cookie::get('id');
            $wait_list->position = $position;
            $saved = $wait_list->save();
            if($saved){
                $request->session()->flash('alert-class', 'alert-success');
                $request->session()->flash('message', "You have been successfully added to the group wait list");
                return redirect()->route('join_group');
            }
        }catch(\Exception $e){
            return $e;
            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message',"Something went wrong, please try again");
            return redirect()->route('join_group');
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
        $list = WaitList::where('group_id', $id)->get();
        return view('dashboard.wait_list')->with('list', $list);
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
