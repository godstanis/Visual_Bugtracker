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
            $issue = null;
            if($commentPoint->issue !== null) {
                $issue = [
                    'id' => $commentPoint->issue->id,
                    'title' => $commentPoint->issue->title,
                    'description' => $commentPoint->issue->description,
                    'url' => route('project.issue.discussion', ['project_id'=>$commentPoint->issue->project_id, 'issue_id'=>$commentPoint->issue->id]),
                ];
            }

            $commentPoints[] = [
                'id' => $commentPoint->id,
                'board_id' => $commentPoint->board_id,
                'text' => $commentPoint->text,
                'position_x' => $commentPoint->position_x,
                'position_y' => $commentPoint->position_y,
                'creator' => [
                    'name' => $commentPoint->creator->name,
                    'email' => $commentPoint->creator->email,
                    'profile_image' => $commentPoint->creator->profile_image,
                    'profile_image_link' => $commentPoint->creator->imageLink(),
                    'url' => route('user', ['user_id'=>$commentPoint->creator->id]),
                ],
                'issue' => $issue
            ];
        }

        return $commentPoints;
    }
}
