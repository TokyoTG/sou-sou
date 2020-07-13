<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cookie;


use App\User;

use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //

  public function index(){
    return view('login');
  }  


  public function login(Request $request){
        $messages = [
            'required' => 'All input fields are required',
            'email'=> "Invalid email"
        ];
        if ($request->all()) {
            $validator = Validator::make($request->all(), [
                'password' => 'required',
                'email' => 'required|email',
            ], $messages);
            if ($validator->fails()) {
                $errors = $validator->errors();
                foreach ($errors->all() as $message) {
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', $message);
                    return redirect()->route('login');
                }
            } else {
                    try{
                        $email = $request->input('email');
                        $password = $request->input('password');
                        $user = User::where('email', $email)->get();
                        if(count($user) > 0){
                            $user_details = $user[0];
                            if(password_verify($password, $user_details->password)){
                                Cookie::queue('full_name', $user_details->full_name);
                                Cookie::queue('role', $user_details->role);
                                Cookie::queue('id', $user_details->id);
                                Cookie::queue('groups_in', $user_details->groups_in);
                                return redirect()->route('dashboard.index')->with('user',$user_details);
                            }   
                        }
                        $request->session()->flash('alert-class', 'alert-danger');
                        $request->session()->flash('message', "Invalid email or password");
                        return redirect()->route('login');
                    }catch(\Exception $e){
                        $request->session()->flash('alert-class', 'alert-danger');
                        $request->session()->flash('message', "Something bad happened, try again");
                        return redirect()->route('login');
                    }
                
            }
        }
    }
}
