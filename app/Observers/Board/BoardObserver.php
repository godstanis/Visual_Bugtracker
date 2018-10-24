<?php

namespace App\Observers\Board;

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
        if(!isset($board->user_id)) {
            $board->user_id = auth()->user()->id;
        }
    }

    /**
     * Listens to the Board creating event and apply issue creator.
     *
     * @param Board $board
     */
    public function deleting(Board $board)
    {
        $board->paths()->delete();
        $board->commentPoints()->delete();
    }
}