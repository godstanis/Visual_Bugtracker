<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserActivation extends Model
{
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
