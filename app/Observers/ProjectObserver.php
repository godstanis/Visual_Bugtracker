<?php

namespace App\Observers;

use App\Project;
use App\ProjectAccess;

class ProjectObserver
{

    /**
     * Handle the Project "created" event and create
     * according project access for creator.
     *
     * @param  Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        $project_access = app()->make(ProjectAccess::class);
        $project_access->user_id = $project->creator_user_id;
        $project_access->project_id = $project->id;

        $project_access->save();

        \Log::info('Project with id:'.$project->id.'created by user with id:'.$project->creator_user_id);
    }

    /**
     * Listen to the Project deleting event
     * and delete all binded models.
     *
     * @param  Project  $project
     * @return void
     */
    public function deleting(Project $project)
    {
        $project->project_access()->delete();
        $project->issues()->delete();
        $project->boards()->delete();
        $project->activities()->delete();

        \Log::info('Project deleted (id:' . $project->id . ')');
    }
}