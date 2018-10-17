<?php

namespace App\Http\Resources;

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
        $data = [];

        foreach ($this->collection as $path) {
            $data[$path->path_slug] = [
                'stroke'=>$path->stroke_color,
                'stroke-width'=>$path->stroke_width,
                'd'=>$path->path_data,
                'info' => [
                    'creator_id' => $path->creator->id
                ]
            ];
        }

        return $data;
    }
}
