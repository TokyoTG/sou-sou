<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $table = "groups";

    protected $fillable = [
        'name',
        'status',
    ];

    public function group_users()
    {
        return $this->hasMany('App\GroupUser');
    }

    public function tasks()
    {
        return $this->hasMany("App\Notification");
    }
}
