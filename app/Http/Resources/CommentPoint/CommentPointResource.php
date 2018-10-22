<?php

namespace App\Http\Resources\CommentPoint;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentPointResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $commentPoint = [
            'id' => $this->id,
            'board_id' => $this->board_id,
            'text' => $this->text,
            'position_x' => $this->position_x,
            'position_y' => $this->position_y,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'creator' => $this->creator,
            'issue' => $this->issue,
            'url' => [
                'issue' => $this->issue ? route('project.issue.discussion', ['issue'=>$this->issue, 'project'=>$this->issue->project]): null,
                'creator_avatar' => $this->creator->imageLink()
            ]
        ];

        return $commentPoint;
    }
}
