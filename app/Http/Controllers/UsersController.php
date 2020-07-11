<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Member;

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
        $users = Member::all();
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
            "min.first_name" => "First name can not be  less than 3",
            "min.last_name" => "Last name can not be  less than 3",
            "email" => "Please enter a valid email",
            "regex" => "Password must be at least 6 alphanumeric characters"
        ];
        if ($request->all()) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|regex:/^(?=.*\d)(?=.*[a-z]).{6,20}$/|confirmed',
                'phone_number' => 'required|min:6|max:16',
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
                    $user = new Member();
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
                    }
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message',"Something went wrong with your registeration, please try again");
                    return redirect()->route('register');
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
        return view('dashboard.singleUser');
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
