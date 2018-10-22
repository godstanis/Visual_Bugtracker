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
            $commentPoints[] = [
                'id' => $commentPoint->id,
                'board_id' => $commentPoint->board_id,
                'text' => $commentPoint->text,
                'position_x' => $commentPoint->position_x,
                'position_y' => $commentPoint->position_y,
                'created_at' => $commentPoint->created_at,
                'updated_at' => $commentPoint->updated_at,
                'creator' => $commentPoint->creator,
                'issue' => $commentPoint->issue,
                'url' => [
                    'issue' => $commentPoint->issue ? route('project.issue.discussion', ['issue'=>$commentPoint->issue, 'project'=>$commentPoint->issue->project]): null,
                    'creator_avatar' => $commentPoint->creator->imageLink()
                ]
            ];
        }

        return $commentPoints;
    }
}
