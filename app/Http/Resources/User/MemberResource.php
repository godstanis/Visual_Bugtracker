<?php

namespace App\Http\Resources\User;

use App\Project;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{

    protected $project;

    public function __construct($resource, Project $project)
    {
        parent::__construct($resource);
        $this->project = $project;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        self::withoutWrapping(); // {"data":[...]} wrapping remove for this response.

        $abilities = [];
        $abilities['create'] = $this->can('delete', $this->project);
        $abilities['manage'] = $this->can('manage', $this->project);

        $user = [
            'name' => $this->name,
            'email' => $this->email,
            'profile_image_url' => $this->imageLink(),
            'profile_url' => route('user', ['user' => $this]),
            'abilities' => $abilities,
        ];

        return $user;
    }
}
