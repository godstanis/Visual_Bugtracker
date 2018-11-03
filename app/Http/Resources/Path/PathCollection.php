<?php

namespace App\Http\Resources\Path;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PathCollection extends ResourceCollection
{
    /**
     * Return json object of paths, related to the board.
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        self::withoutWrapping(); // {"data":[...]} wrapping remove for this response.
        $paths = [];

        foreach ($this->collection as $path) {
            $paths[] = (new PathResource($path))->toArray($request);
        }

        return $paths;
    }
}
