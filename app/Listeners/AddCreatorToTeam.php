<?php

namespace App\listeners;

use App\Events\ProjectCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddCreatorToTeam
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProjectCreated  $event
     * @return void
     */
    public function handle(ProjectCreated $event)
    {
        $project = $event->project;

        $project_access = new \App\ProjectAccess;

        $project_access->user_id = $project->creator_user_id;
        $project_access->project_id = $project->id;

        $project_access->save();

        \Log::info('Project with id:'.$project->id.'created by user with id:'.$project->creator_user_id);
    }
}
