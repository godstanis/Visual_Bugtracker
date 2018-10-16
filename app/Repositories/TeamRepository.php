<?php

namespace App\Repositories;

use App\ProjectAccess;

class TeamRepository
{
    public function delete(\App\User $user, \App\Project $project)
    {
        $user->projects()->detach($project);
    }
}