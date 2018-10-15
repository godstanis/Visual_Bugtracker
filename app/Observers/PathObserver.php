<?php

namespace App\Observers;

use App\Path;

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
        $path->created_by_user_id = auth()->user()->id;

        $pathSlug = uniqid('path_', false).str_random(4);
        $path->path_slug = $pathSlug;
    }

    /**
     * Listen to the Path deleting event.
     *
     * @param  Path  $path
     * @return void
     */
    public function deleting(Path $path)
    {
        //
    }
}