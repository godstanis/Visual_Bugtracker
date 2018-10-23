<?php

namespace App\Observers;

use App\Path;

use App\Events\Pusher\Board\Path\PathCreated;
use App\Events\Pusher\Board\Path\PathDeleted;

class PathObserver
{
    /**
     * Listen to the Path creating event and apply issue creator.
     *
     * @param  Path  $path
     * @return void
     */
    public function creating(Path $path)
    {
        $path->user_id = auth()->user()->id;

        $pathSlug = uniqid('path_', false).str_random(4);
        $path->path_slug = $pathSlug;
    }

    /**
     * Listen to the Path created event.
     *
     * @param  Path  $path
     * @return void
     */
    public function created(Path $path)
    {
        broadcast( new PathCreated($path) )->toOthers();
    }

    /**
     * Listen to the Path deleted event.
     *
     * @param  Path  $path
     * @return void
     */
    public function deleted(Path $path)
    {
        broadcast( new PathDeleted($path) )->toOthers();
    }
}