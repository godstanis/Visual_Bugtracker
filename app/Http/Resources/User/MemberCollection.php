<?php

namespace App\Http\Resources\User;

use App\Project;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MemberCollection extends ResourceCollection
{
    protected $project;

    public function __construct($resource, Project $project)
    {
        parent::__construct($resource);
        $this->project = $project;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        self::withoutWrapping(); // {"data":[...]} wrapping remove for this response.
        $users = [];

        foreach ($this->collection as $user) {
            $users[] = (new MemberResource($user, $this->project))->toArray($request);
        }

        return $users;
    }
}
