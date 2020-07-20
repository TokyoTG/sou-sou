<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotRequest;
use App\Mail\ResetSuccessful;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\PasswordReset;

class ForgotPasswordController extends Controller
{
    //
    public function index(Request $request){

        $request->validate([
            'email' => ['required','email']
        ]);
        $email = $request->input('email');

        try{
            $is_user = User::where('email',$email)->get();
            if(count($is_user) > 0){

            //generate token
            $token = "";
            $alphabets = [0,1,2,3,4,5,6,7,8,9,0];
            for ($i = 0; $i < 7; $i++) {
                $index = mt_rand(0, count($alphabets) - 1);
                $token .= $alphabets[$index];
            }

            $has_sent = PasswordReset::where('email',$email)->get();
            if(count($has_sent) > 0){
                $update = PasswordReset::find($has_sent[0]->id);
                $update->token = $token;
                $update->save();
            }else{
                $reset = new PasswordReset();
                $reset->email = $email;
                $reset->token = $token;
                $reset->save();
            }
            $data = [
                'otp' => $token,
                'user_name' => $is_user[0]->full_name
            ];
            Mail::to($email)->send(new ForgotRequest($data));
            }else{
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message', "User not found, email not registered with us");
                return redirect()->route('forgot');
            }


            $request->session()->flash('alert-class', 'alert-success');
            $request->session()->flash('message', "Request successful, check your email for reset token");
            return redirect()->route('reset');
        }catch(\Exception $e){
            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message', "Something went wrong with you request, please try again");
            return redirect()->route('forgot');
        }
        
    }

    public function reset(Request $request){
        $messages = [
            'required' => 'All input fields are required',
            "regex" => "Password must be at least 6 alphanumeric characters"
        ];
        if ($request->all()) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|regex:/^(?=.*\d)(?=.*[a-z]).{6,20}$/|confirmed',
                'token' => 'required',
            ], $messages);
            if ($validator->fails()) {
                $errors = $validator->errors();
                foreach ($errors->all() as $message) {
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', $message);
                    return redirect()->route('reset');
                }
            } else {
                try{
                    $token = $request->input('token');
                    $token_info = PasswordReset::where('token',$token)->first();
                    if($token_info){
                        $user_email = $token_info->email;
                        User::where('email',$user_email)->update([
                            'password' => password_hash($request->input('password'), PASSWORD_DEFAULT)
                        ]);
                        PasswordReset::where('email',$user_email)->delete();

                         //send email
                        Mail::to($user_email)->send(new ResetSuccessful());
                       
                        $request->session()->flash('alert-class', 'alert-success');
                        $request->session()->flash('message', "Password reset was successful, you can now login");
                        return redirect()->route('login');
                    }else{
                        $request->session()->flash('alert-class', 'alert-danger');
                        $request->session()->flash('message', "Token expired or invalid");
                        return redirect()->route('reset');
                    }
                   
                }catch(\Exception $e){
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', "Something went wrong with you request, please try again");
                    return redirect()->route('reset');
                }
               
            }
        }
    }
}
