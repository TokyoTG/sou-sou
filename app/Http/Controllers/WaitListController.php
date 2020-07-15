<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\WaitList;

use Illuminate\Support\Facades\Validator;

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
        $user_id = Cookie::get('id');
        try{
            $check_user =   WaitList::where('group_id',$group_id)->where('user_id',$user_id)->get();
            if(count($check_user) > 0){
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message',"You have already joined this group");
                return redirect()->route('join_group');
            }
            $position = count(WaitList::where('group_id',$group_id)->get()) + 1;
            $wait_list = new WaitList;
            $wait_list->group_id = $group_id;
            $wait_list->user_id = Cookie::get('id');
            $wait_list->group_name = $group_name;
            $wait_list->user_name = Cookie::get('full_name');
            $wait_list->position = $position;
            $saved = $wait_list->save();
            if($saved){
                $request->session()->flash('alert-class', 'alert-success');
                $request->session()->flash('message', "You have been successfully added to the group wait list");
                return redirect()->route('join_group');
            }
        }catch(\Exception $e){
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
        $list = WaitList::where('group_id', $id)->orderBy('position', 'asc')->get();
        // return $list;
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
        $group_id = $request->input('group_id');
        if ($request->all()) {
            $validator = Validator::make($request->all(), [
                'input-position' => 'required|digits_between:1,7'
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                foreach ($errors->all() as $message) {
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', $message);
                        return redirect()->route('wait_list.show',$group_id);
                    
                }
            } else {
                try{
                    $input_postion =intval( $request->input('input-position'));
                    $old_position = intval( $request->input('old_position'));
                    $list_id = $request->input('list_id');
                    $position = count(WaitList::where('group_id',$group_id)->get());
                    if($input_postion > $position || $input_postion <= 0){
                        $request->session()->flash('alert-class', 'alert-danger');
                        $request->session()->flash('message',"Invalid position");
                        return redirect()->route('wait_list.show',$group_id);
                    }else{
                        WaitList::where('position',$input_postion)
                        ->where('group_id',$group_id)->update(['position'=> $old_position]);
                        WaitList::where('user_id',$id)->where('group_id',$group_id)->update(['position'=>$input_postion]);
                        $request->session()->flash('alert-class', 'alert-success');
                        $request->session()->flash('message', "Position updated successfully");
                        return redirect()->route('wait_list.show',$group_id);
                    }

                }catch(\Exception $e){
                        $request->session()->flash('alert-class', 'alert-danger');
                        $request->session()->flash('message',"Something went wrong with your request, please try again");
                        return redirect()->route('wait_list.show',$group_id);
                }
                
              
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
        try{
            $group_id = $request->input('group_id');
            $item = WaitList::find($id);
            $item->delete();
            $request->session()->flash('alert-class', 'alert-success');
            $request->session()->flash('message', "User removed successfully");
            return redirect()->route('wait_list.show',$group_id);
        }catch(\Exception $e){
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message',"Something went wrong with your request, please try again");
                return redirect()->route('wait_list.show',$group_id);
        }
    }
}
