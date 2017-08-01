<?php

namespace App\Http\Controllers\Bugtracker;

use Illuminate\Http\Request;
use App\Http\Controllers\BugtrackerBaseController;

use App\Activity;
use App\Project;

class ActivityController extends BugtrackerBaseController
{
    /*
     * Show all project activity
    */
    public function getProjectActivities(Project $project)
    {
        $activities = $project->activities;
        
        return view('bugtracker.project.activity', ['activities'=>$activities, 'project'=>$project]);
    }
}
