<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaitList extends Model
{
    //

    protected $table = 'wait_list';

    protected $fillable = [
        'position',
        'frequency',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
