<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cookie;


use App\User;
use App\Notification;

use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //

  public function index(){
    return view('login');
  }  


  public function login(Request $request){
      $time = date('H');
      $int_time = intval($time);
    //   return $int_time;
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
                                if($user_details->role != 'admin'){
                                    if($int_time < 8 && $int_time > 20){
                                        $request->session()->flash('alert-class', 'alert-danger');
                                        $request->session()->flash('message', "The platform is inactive anytime beyond 8AM and 8PM");
                                        return redirect()->route('login');
                                    } 
                                }
                                
                                $tasks = Notification::where('user_id',$user_details->id)->where('is_read',false)->get();
                                session(['tasks' => $tasks]);
                                Cookie::queue('full_name', $user_details->full_name);
                                Cookie::queue('role', $user_details->role);
                                Cookie::queue('email', $user_details->email);
                                Cookie::queue('id', $user_details->id);
                                Cookie::queue('expires', strtotime('+ 1 day'));
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
