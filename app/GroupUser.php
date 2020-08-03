<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    //
    protected $table = "group_users";

    public function user(){
        return $this->belongsTo('App\User',"user_id");
    }
}
