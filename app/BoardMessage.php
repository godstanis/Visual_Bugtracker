<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BoardMessage
 *
 * TODO: #1 Issue, programm the board message logic.
 *
 * @package App
 */
class BoardMessage extends Model
{

    protected $fillable = ['board_id', 'text', 'issue_id'];

    public function board()
    {
        return $this->belongsTo('\App\Board', 'board_id', 'id');
    }
}
