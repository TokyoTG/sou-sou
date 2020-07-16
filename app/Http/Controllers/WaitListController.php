<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\WaitList;

use Illuminate\Support\Facades\Validator;

use App\Group;
use App\GroupUser;
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
        $list = WaitList::orderBy('position', 'asc')->get();
        $groups = Group::where('status',"open")->get('name');
        // return $list;
        $data = ['groups'=>$groups, 'list'=>$list];
        return view('dashboard.wait_list')->with('data', $data);
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
        $user_id = Cookie::get('id');
        try{
            // $check_user =   WaitList::where('user_id',$user_id)->get('id');
           
            // if(count($check_user) >= 4){
            //     $request->session()->flash('alert-class', 'alert-danger');
            //     $request->session()->flash('message',"You can not join the join waiting list more than 4 times");
            //     return redirect()->route('dashboard.index');
            // }
            $position = count(WaitList::all()) + 1;
            $wait_list = new WaitList;
            $wait_list->user_id = Cookie::get('id');
            $wait_list->user_name = Cookie::get('full_name');
            $wait_list->position = $position;
            $saved = $wait_list->save();
            if($saved){
                $request->session()->flash('alert-class', 'alert-success');
                $request->session()->flash('message', "You have been successfully added to the wait list");
                return redirect()->route('dashboard.index');
            }
        }catch(\Exception $e){
            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message',"Something went wrong, please try again");
            return redirect()->route('dashboard.index');
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
       
        if ($request->all()) {
            $validator = Validator::make($request->all(), [
                'input-position' => 'required|digits_between:1,7'
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                foreach ($errors->all() as $message) {
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', $message);
                        return redirect()->route('wait_list.index');
                    
                }
            } else {
                try{
                    $input_postion =intval( $request->input('input-position'));
                    $old_position = intval( $request->input('old_position'));
                    $position = count(WaitList::all());
                    if($input_postion > $position || $input_postion <= 0){
                        $request->session()->flash('alert-class', 'alert-danger');
                        $request->session()->flash('message',"Invalid position");
                        return redirect()->route('wait_list.index');
                    }else{
                        WaitList::where('position',$input_postion)->update(['position'=> $old_position]);
                        WaitList::where('user_id',$id)->update(['position'=>$input_postion]);
                        $request->session()->flash('alert-class', 'alert-success');
                        $request->session()->flash('message', "Position updated successfully");
                        return redirect()->route('wait_list.index');
                    }

                }catch(\Exception $e){
                        $request->session()->flash('alert-class', 'alert-danger');
                        $request->session()->flash('message',"Something went wrong with your request, please try again");
                        return redirect()->route('wait_list.index');
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
            $item = WaitList::find($id);
            $item->delete();
            $request->session()->flash('alert-class', 'alert-success');
            $request->session()->flash('message', "User removed successfully");
            return redirect()->route('wait_list.index');
        }catch(\Exception $e){
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message',"Something went wrong with your request, please try again");
                return redirect()->route('wait_list.index');
        }
    }
}
