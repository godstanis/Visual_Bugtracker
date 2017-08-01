<?php

namespace App\Repositories;

use App\Path;

class PathRepository
{

    public function getBySlug($slug)
    {
        return Path::where('path_slug', $slug)->first();
    }

    public function save($data)
    {
        $newPath = Path::create($data);
        $newPath->save();

        broadcast( new \App\Events\Pusher\PathCreated($newPath) )->toOthers();

        return $newPath;
    }

    public function deleteBySlug($path_slug)
    {
        $path = $this->getBySlug($path_slug);

        if( auth()->user()->can('delete', $path) )
        {
            broadcast( new \App\Events\Pusher\PathDeleted($path) )->toOthers();
            return $path->delete();
        }
        
    }
}