<?php

namespace App\Http\Resources\Path;

use Illuminate\Http\Resources\Json\JsonResource;

class PathResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //self::withoutWrapping(); // {"data":[...]} wrapping remove for this response.

        $path = [
            'path_slug'=>$this->path_slug,
            'stroke'=>$this->stroke_color,
            'stroke-width'=>$this->stroke_width,
            'd'=>$this->path_data
        ];

        return $path;
    }
}
