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
        if(!isset($project->user_id)) {
            $project->user_id = auth()->user()->id;
        }
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
        $project->members()->attach($project->creator);
        $project->creator->allow()->to('manage', $project);

        \Log::info('Project with id:'.$project->id.'created by user with id:'.$project->user_id);
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

        /*
         * Each board deletion needed to trigger board deleted event.
         * In order to fire the events we would have to pull the
         * models first and then call the events with the model
         * instances. Then call the delete query.
         */
        $project->boards()->each(function($board) {
            $board->delete();
        });
        $project->activities()->delete();

        \Log::info('Project deleted (id:' . $project->id . ')');
    }
}