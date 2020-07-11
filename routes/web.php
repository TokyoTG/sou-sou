<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login',"LoginController@index")->name('login');

Route::post('/login',"LoginController@login")->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/forgot_pasword', function () {
    return view('forgot');
})->name('forgot');


Route::get('/reset_password', function () {
    return view('reset');
})->name('reset');



Route::prefix('/dashboard')->group(function () {
    Route::get('/home', function () {
        return view('dashboard.index');
    })->name('dashboard.index');


    Route::get('/logout', 'LogoutController@index')->name('logout');

    //users section
    Route::resource('users', 'UsersController');

    //end users section

    //groups section
    Route::resource('groups', 'GroupController');

    //end groups section

    Route::get('/join_group', function () {
        return view('dashboard.join_group');
    })->name('join_group');


    Route::get('/settings', function () {
        return view('dashboard.settings');
    })->name('dashboard.settings');


    Route::get('/notifications', function () {
        return view('dashboard.notifications');
    })->name('dashboard.notifications');


    Route::get('/complaints', function () {
        return view('dashboard.complaints');
    })->name('dashboard.complaints');

    Route::get('/wait_list', function () {
        return view('dashboard.wait_list');
    })->name('dashboard.wait_list');
});
