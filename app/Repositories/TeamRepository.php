<?php

namespace App\Repositories;

use App\ProjectAccess;

class TeamRepository
{
    public function all()
    {
        
    }


    public function delete(\App\User $user, \App\Project $project)
    {
        $project_access = $user->project_access->where('project_id', $project->id)->first();

        $project_access->delete();
    }  

    public function add($data)
    {
        $newProjectAccess = ProjectAccess::create([
            'user_id' => $data['user_id'],
            'project_id' => $data['project_id']
        ]);

        return $newProjectAccess->save();
    }


}