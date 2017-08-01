<?php

namespace App\Http\Controllers\Bugtracker;

use Illuminate\Http\Request;
use App\Http\Controllers\BugtrackerBaseController;

use App\Repositories\ProjectRepository;

use App\Project;

class ProjectsController extends BugtrackerBaseController
{

    protected $project_repository;

    public function __construct(ProjectRepository $repository)
    {
        $this->project_repository = $repository;
    }

    /*
     * Show all projects
    */
    public function getAllProjects()
    {
        $projects = $this->project_repository->all();
        
        return view('bugtracker.projects', compact('projects'));

    }

    /*
     * Show projects, which current user can access
    */
    public function getAvailableProjects()
    {
        $projects = $this->project_repository->getByAccessArray(auth()->user()->project_access);

        return view('bugtracker.projects', ['projects'=>$projects]);
    }

    /*
     * Get project by project index (id), and redirect to it's issues
    */
    public function getProjectById(Project $project)
    {
        return redirect()->route('project.issues', ['project' => $project]);
        
    }

    /*
     * Create new project, and store it in DataBase
    */
    public function postCreateProject(\App\Http\Requests\CreateProjectRequest $request)
    {

        $data = [
            'name' => $request->project_name,
            'description' => $request->project_description,
            'creator_user_id' => auth()->user()->id,
            'project_image' => $request->file('project_image'),
        ];
        
        return $this->project_repository->create($data);
      
    }


    /*
     * Delete existing project
    */
    public function postDeleteProject(Project $project)
    {
        
        $this->project_repository->delete($project, auth()->user());

        $response = ['status' => true];
        return json_encode($response);

    }

    public function getSettingsPage(Project $project)
    {
        return view('bugtracker.project.settings', ['project'=>$project]);
    }

    /*
     * Update project properties, and save it in DataBase
    */
    public function postUpdateProject(\App\Http\Requests\UpdateProjectRequest $request, Project $project)
    {

        $project->name = $request->project_name;
        $project->description = $request->project_description;
        $project->website_url = $request->project_url;

        $project->update();

        return redirect()->back();

    }

}
