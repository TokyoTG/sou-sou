<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $table = "groups";

    public function group_users(){
        return $this->hasMany('App\GroupUser');
    }
}
