<?php

namespace App\Http\Controllers\Bugtracker;

use App\Http\Controllers\BugtrackerBaseController;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends BugtrackerBaseController
{

    /*
     * Show projects, which current user can access
    */
    public function getAvailableProjects()
    {
        $projects = auth()->user()->projects;
        $projects->load('issues','boards', 'members');

        return view('bugtracker.projects', ['projects'=>$projects]);
    }

    /*
     * Get project by project index (id), and redirect to it's issues
    */
    public function getProjectById(Project $project)
    {
        return redirect()->route('project.issues', compact('project'));
    }

    /*
     * Create new project, and store it in DataBase
    */
    public function postCreateProject(CreateProjectRequest $request, Project $project)
    {
        $newProject = $project->create($request->all());

        if($request->ajax()) {
            return view('bugtracker.project-box', ['project' => $newProject]);
        }

        return redirect()->back();
    }


    /*
     * Delete existing project
    */
    public function postDeleteProject(Request $request, Project $project)
    {
        $project->delete();

        if($request->ajax()) {
            return response("", 200);
        }

        return redirect()->back();
    }

    /**
     * Renders project settings page.
     *
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSettingsPage(Request $request, Project $project)
    {
        return view('bugtracker.project.settings', compact('project'));
    }

    /**
     * Updates project properties.
     *
     * @param UpdateProjectRequest $request
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdateProject(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->all());

        return redirect()->back();
    }

}
