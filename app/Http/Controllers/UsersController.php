<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\User;

use App\GroupUser;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        // return $users;
        return view('dashboard.users')->with('users',$users);
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
            "regex" => "Password must be at least 6 alphanumeric characters"
        ];
        if ($request->all()) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|regex:/^(?=.*\d)(?=.*[a-z]).{6,20}$/|confirmed',
                'phone_number' => 'required|digits_between:6,16',
                'first_name' => 'required|alpha|min:3|max:16',
                'email' => 'required|email',
                'last_name' => 'required|alpha|min:3|max:16',
            ], $messages);
            if ($validator->fails()) {
                $errors = $validator->errors();
                foreach ($errors->all() as $message) {
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', $message);
                    return redirect()->route('register');
                }
            } else {
                try{
                    $user = new User();
                    $user->full_name = $request->input('first_name') . " " . $request->input('last_name');
                    $user->email = $request->input('email');
                    $user->phone_number = $request->input('phone_number');
                    $user->password = password_hash($request->input('password'), PASSWORD_DEFAULT);
                    $user->role = "member";
                    $user->groups_in = 0;
                    $saved = $user->save();
                    if($saved) {
                         $request->session()->flash('alert-class', 'alert-success');
                        $request->session()->flash('message', "You successfully register, you can now login");
                        return redirect()->route('login');
                    }else{
                          $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message',"Something went wrong with your registeration, please try again");
                    return redirect()->route('register');
                    }
                  
                } catch(\Exception $e){
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message',"Something went wrong with your registeration, please try again");
                    return redirect()->route('register');
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
        $user = User::find($id);
        $userGroup = GroupUser::where('user_id',$id)->get();
        $user_details = ['info'=>$user,'group_info'=>$userGroup];
        // return $user_details;
        return view('dashboard.singleUser')->with('user_details',$user_details);
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
        $user = User::find($id);
        $userGroup = GroupUser::where('user_id',$id)->get();
        return view('dashboard.settings')->with('user',$user);
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
        $messages = [
            'required' => 'All input fields are required',
            "regex" => "Password must be at least 6 alphanumeric characters"
        ];
        if ($request->all()) {
            if($request->input('request_control') =="profile-update"){
                $validator = Validator::make($request->all(), [
                'phone_number' => 'required|digits_between:8,16',
                'first_name' => 'required|alpha|min:3|max:16',
                'email' => 'required|email',
                'account_number' => 'required|digits_between:6,16',
                'last_name' => 'required|alpha|min:3|max:16',
                ], $messages);
            }elseif($request->input('request_control') =="password-update"){
                $validator = Validator::make($request->all(), [
                    'password' => 'required|regex:/^(?=.*\d)(?=.*[a-z]).{6,20}$/|confirmed',
                    ], $messages);
            }

            if ($validator->fails()) {
                $errors = $validator->errors();
                foreach ($errors->all() as $message) {
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', $message);
                    return redirect()->route('users.edit',$id);
                }
            } else {

                    try{
                        $user = User::find($id);
                        if($request->input('request_control') =="profile-update"){
                            $user->full_name = $request->input('first_name') . " " . $request->input('last_name');
                            $user->email = $request->input('email');
                            $user->phone_number = $request->input('phone_number');
                            $user->account_number = $request->input('account_number');
                            $saved = $user->save();
                            if($saved){
                                $request->session()->flash('alert-class', 'alert-success');
                                $request->session()->flash('message', "Profile details updated successfully");
                                return redirect()->route('users.edit',$id);
                            }else{
                                $request->session()->flash('alert-class', 'alert-danger');
                                $request->session()->flash('message',"Something went wrong with your request, please try again");
                                return redirect()->route('users.edit',$id);
                            }
                        }elseif($request->input('request_control') =="password-update"){
                            if(password_verify($request->input('old_password'), $user->password)){
                                $user->password = password_hash($request->input('password'), PASSWORD_DEFAULT);
                                $saved = $user->save();
                                if($saved){
                                    $request->session()->flash('alert-class', 'alert-success');
                                    $request->session()->flash('message', "Profile details updated successfully");
                                    return redirect()->route('users.edit',$id);
                                }else{
                                    $request->session()->flash('alert-class', 'alert-danger');
                                    $request->session()->flash('message',"Something went wrong with your request, please try again");
                                    return redirect()->route('users.edit',$id);
                                }
                            }else{
                                $request->session()->flash('alert-class', 'alert-danger');
                                $request->session()->flash('message',"Old password you provided is wrong");
                                return redirect()->route('users.edit',$id);
                            }
                        }
                    } catch(\Exception $e){
                        $request->session()->flash('alert-class', 'alert-danger');
                        $request->session()->flash('message',"Something went wrong with your request, please try again");
                        return redirect()->route('users.edit',$id);
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
    public function destroy($id)
    {
        //
    }


}
