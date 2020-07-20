<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotRequest;

use App\User;
use App\PasswordReset;

class ForgotPasswordController extends Controller
{
    //
    public function index(Request $request){


        $email = $request->input('email');

        try{
            $is_user = User::where('email',$email)->count();
            if($is_user){

            //generate token
            $token = "";
            $alphabets = ['a', 'b', 'A', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'i', 'I', 'j', 'm', "M", 'y', 'z', 'w', 'Z'];
            for ($i = 0; $i < 10; $i++) {
                $index = mt_rand(0, count($alphabets) - 1);
                $token .= $alphabets[$index];
            }

            $has_sent = PasswordReset::where('email',$email)->get();
            if(count($has_sent) > 0){
                $update = PasswordReset::find($has_sent->id);
                $update->token = $token;
                $update->save();
            }else{
                $reset = new PasswordReset();
                $reset->email = $email;
                $reset->token = $token;
                $reset->save();
            }
            // Mail::to($email)->send(new ForgotRequest($token));
            }else{
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message', "User not found, email not registered with us");
                return redirect()->route('forgot');
            }
            // return $email;
            $token = "";
            $alphabets = ['a', 'b', 'A', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'i', 'I', 'j', 'm', "M", 'y', 'z', 'w', 'Z'];

            for ($i = 0; $i < 10; $i++) {
                $index = mt_rand(0, count($alphabets) - 1);
                $token .= $alphabets[$index];
            }

           
            Mail::to($email)->send(new ForgotRequest($token));


            $request->session()->flash('alert-class', 'alert-success');
            $request->session()->flash('message', "Request successful, check your email for token");
            return redirect()->route('forgot');
        }catch(\Exception $e){
            return $e;
            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message', "Something went wrong with you request, please try again");
            return redirect()->route('forgot');
        }
        
    }
}
