<?php

namespace App\Http\Resources\CommentPoint;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentPointCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        self::withoutWrapping(); // {"data":[...]} wrapping remove for this response.
        $commentPoints = [];

        foreach ($this->collection as $commentPoint) {
            $commentPoints[] = (new CommentPointResource($commentPoint))->toArray($request);
        }

        return $commentPoints;
    }
}
