<?php

namespace App\Listeners;

use App\Events\ProjectDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteProjectData //implements ShouldQueue
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
     * @param  ProjectDeleted  $event
     * @return void
     */
    public function handle(ProjectDeleted $event)
    {
        
        $project_id = $event->project_id;
        
        $issues = \App\Issue::where('project_id', '=', $project_id);
        $boards = \App\Board::where('project_id', '=', $project_id);
        $activity = \App\Activity::where('project_id', '=', $project_id);
        
        $issues->update(['deleted'=>true]);
        $boards->update(['deleted'=>true]);
        $activity->update(['deleted'=>true]);
        
        \Log::info('Project deleted (id:' . $project_id . ')');
        
    }

}
