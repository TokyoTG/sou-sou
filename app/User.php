<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $table = "users";

    public function groups(){
        $this->hasMany('App\GroupUser',"user_id");
    }
}
