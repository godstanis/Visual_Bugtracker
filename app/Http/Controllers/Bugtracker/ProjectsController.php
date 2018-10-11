<?php

namespace App\Http\Controllers\Bugtracker;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
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
    public function postCreateProject(CreateProjectRequest $request)
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

    /**
     * Renders project settings page.
     *
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSettingsPage(Project $project)
    {
        return view('bugtracker.project.settings', ['project'=>$project]);
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
