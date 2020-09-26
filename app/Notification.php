<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $fillable = [
        'user_id',
        'group_user_id',
        'group_id',
        'title',
        'user_name',
        'completed',
        'is_read',
        'is_verified'
    ];
    public function group()
    {
        return $this->belongsTo("App\Group");
    }
}
