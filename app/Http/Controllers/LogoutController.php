<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cookie;

class LogoutController extends Controller
{
    //

    public function index(Request $request)
    {
        Cookie::queue(Cookie::forget('role'));
        Cookie::queue(Cookie::forget('id'));
        Cookie::queue(Cookie::forget('groups_in'));
        Cookie::queue(Cookie::forget('account_number'));
        Cookie::queue(Cookie::forget('phone_number'));
        Cookie::queue(Cookie::forget('first_name'));
        Cookie::queue(Cookie::forget('last_name'));
        Cookie::queue(Cookie::forget('email'));

        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
