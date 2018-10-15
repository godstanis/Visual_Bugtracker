<?php

namespace App\Observers;

use App\Board;

class BoardObserver
{

    /**
     * Listens to the Board creating event and apply issue creator.
     *
     * @param Board $board
     */
    public function creating(Board $board)
    {
        $board->created_by_user_id = auth()->user()->id;
    }
}