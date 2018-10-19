<?php

namespace App\Observers;

use App\CommentPoint;
use App\Events\Pusher\Board\CommentPoint\CommentPointCreated;
use App\Events\Pusher\Board\CommentPoint\CommentPointDeleted;

class CommentPointObserver
{
    /**
     * Handle the comment point "created" event.
     *
     * @param  \App\CommentPoint  $commentPoint
     * @return void
     */
    public function created(CommentPoint $commentPoint)
    {
        broadcast( new CommentPointCreated($commentPoint) )->toOthers();
    }

    /**
     * Handle the comment point "deleted" event.
     *
     * @param  \App\CommentPoint  $commentPoint
     * @return void
     */
    public function deleted(CommentPoint $commentPoint)
    {
        broadcast( new CommentPointDeleted($commentPoint) )->toOthers();
    }
}
