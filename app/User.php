<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $table = "users";

    protected $fillable = [
        'full_name',
        'phone_number',
        'email',
        'role',
        'group_times',
        'top_times',
        'password'
    ];

    public function groups()
    {
        return  $this->hasMany('App\GroupUser');
    }

    public function wait_lists()
    {
        return $this->hasMany("App\WaitList");
    }
}
