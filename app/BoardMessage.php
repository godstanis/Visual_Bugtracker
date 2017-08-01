<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardMessage extends Model
{

    protected $fillable = ['board_id', 'text', 'issue_id'];

    public function board()
    {
        return $this->belongsTo('\App\Board', 'board_id', 'id');
    }
}
