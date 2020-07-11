<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cookie;

use App\Member;

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
                    $email = $request->input('email');
                    $password = $request->input('password');
                    $user = Member::where('email', $email)->get();
                    if(count($user) > 0){
                        $user_details = $user[0];
                        if(password_verify($password, $user_details->password)){
                            Cookie::queue('full_name', $user_details->full_name);
                            Cookie::queue('email', $user_details->email);
                            Cookie::queue('role', $user_details->role);
                            Cookie::queue('id', $user_details->id);
                            Cookie::queue('account_number', $user_details->account_number);
                            Cookie::queue('groups_in', $user_details->groups_in);
                            Cookie::queue('phone_number', $user_details->phone_number);
                            return redirect()->route('dashboard.index');
                        }   
                    }
                          $request->session()->flash('alert-class', 'alert-danger');
                        $request->session()->flash('message', "Invalid email or password");
                        return redirect()->route('login');
                try{

                }catch(\Exception $e){

                }
                
            }
        }
    }
}
