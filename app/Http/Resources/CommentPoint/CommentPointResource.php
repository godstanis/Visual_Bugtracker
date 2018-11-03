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
        self::withoutWrapping(); // {"data":[...]} wrapping remove for this response.

        $issue = null;
        if($this->issue !== null) {
            $issue = [
                'id' => $this->issue->id,
                'title' => $this->issue->title,
                'description' => $this->issue->description,
                'url' => route('project.issue.discussion', ['project_id'=>$this->issue->project_id, 'issue_id'=>$this->issue->id]),
            ];
        }

        $commentPoint = [
            'id' => $this->id,
            'board_id' => $this->board_id,
            'text' => $this->text,
            'position_x' => $this->position_x,
            'position_y' => $this->position_y,
            'creator' => [
                'name' => $this->creator->name,
                'email' => $this->creator->email,
                'profile_image' => $this->creator->profile_image,
                'profile_image_link' => $this->creator->imageLink(),
                'url' => route('user', ['user_id'=>$this->creator->id]),
            ],
            'issue' => $issue
        ];

        return $commentPoint;
    }
}
