<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    //
    protected $table = "group_users";

    protected $fillable = [
        'user_id',
        'group_id',
        'user_level',
        'task_status'
    ];

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
