<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;

class RegisterController extends Controller
{
    //
    public function index(Request $request)
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
                    if ($e->getCode() == 23000) {
                        // Deal with duplicate key error  
                     $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message',"Email or phone number already exists");
                    return redirect()->route('register');
                    }
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message',"Something went wrong with your registeration, please try again");
                    return redirect()->route('register');
                }

            }
        }
    }
}
