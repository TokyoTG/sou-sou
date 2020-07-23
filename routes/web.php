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
})->name('welcome');

Route::get('/login',"LoginController@index")->name('login');

Route::post('/login',"LoginController@login")->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register','RegisterController@index')->name('signup');

Route::get('/forgot_pasword', function () {
    return view('forgot');
})->name('forgot');

Route::post('/forgot_pasword', 'ForgotPasswordController@index')->name('forgot');
Route::post('/reset_password', 'ForgotPasswordController@reset')->name('reset');


Route::get('/reset_password', function () {
    return view('reset');
})->name('reset');



Route::prefix('/dashboard')->group(function () {
   
    Route::get('/logout', 'LogoutController@index')->name('logout');

    Route::group(['middleware' => 'backend.auth'], function () {

        Route::get('/home', 'PagesController@dashboard')->name('dashboard.index');

    //users section
        Route::resource('users', 'UsersController');

        //end users section

        //groups section
        Route::resource('groups', 'GroupController');

        Route::resource('group_users', 'GroupUserController');
        //end groups section

        Route::get('/list','GroupController@show_user_list' )->name('user_list');


        Route::resource('tasks', 'NotificationController');


        Route::get('/complaints', function () {
            return view('dashboard.complaints');
        })->name('dashboard.complaints');


        //wait list 

        Route::resource('wait_list', 'WaitListController');

        Route::get('/payments', 'PagesController@payments')->name('payments');

        Route::post('/pause',"PagesController@platform")->name('platform');

        Route::post('/generate', "WaitListController@generate_group")->name('generate');

    });
    

   
  
});
