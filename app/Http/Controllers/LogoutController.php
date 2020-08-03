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
        Cookie::queue(Cookie::forget('full_name'));
        Cookie::queue(Cookie::forget('email'));

        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
