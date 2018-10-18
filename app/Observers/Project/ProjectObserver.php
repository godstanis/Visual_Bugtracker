<?php

namespace App\Observers\Project;

use App\Project;
use App\ProjectAccess;

class ProjectObserver
{

    /**
     * Handle the Project "creating" event and create
     * according project access for creator.
     *
     * @param  Project  $project
     * @return void
     */
    public function creating(Project $project)
    {
        $project->creator_user_id = auth()->user()->id;
    }

    /**
     * Handle the Project "created" event and create
     * according project access for creator.
     *
     * @param  Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        $project->members()->attach($project->creator_user_id);

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
        $project->members()->detach();
        $project->issues()->delete();
        $project->boards()->delete();
        $project->activities()->delete();

        \Log::info('Project deleted (id:' . $project->id . ')');
    }
}