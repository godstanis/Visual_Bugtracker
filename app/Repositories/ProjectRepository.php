<?php

namespace App\Repositories;

use App\Project;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Services\FileUpload\FileUploadContract;

class ProjectRepository
{
    protected $uploadService;

    /**
     * ProjectRepository constructor.
     * @param Project $user
     * @param FileUploadContract $uploadService
     */
    public function __construct(Project $project, FileUploadContract $uploadService)
    {
        $this->project = $project;

        $this->uploadService = $uploadService;
    }

    public function all()
    {
        return Project::all();
    }

    public function getByAccessArray($project_access_array)
    {
        $projects = [];

        foreach ($project_access_array as $access) {
            $projects[] = $access->project;
        }

        return $projects;
    }

    public function delete(Project $project, \App\User $user)
    {

        $projectImageDirectory = config('images.project_thumb_dir');
        $projectDefaultImageName = config('images.default_project_thumb');

        if( $project )
        {
            if( $project->thumbnail_img !== $projectDefaultImageName) {
                Storage::delete( $projectImageDirectory.'/'.$project->thumbnail_img );
            }
            if( $project->delete() ) {
                $response['status'] = true;
            }

        }
    }

    /**
     * Creates a project.
     *
     * @param $request  array
     * @return Project
     */
    public function create($request)
    {
        $defaultImageName = config('images.default_project_thumb');

        if( ! isset( $request['thumbnail_img'] ) ) {
            $request['thumbnail_img'] = false;
        }
        $projectImage = &$request['thumbnail_img'];

        if( $projectImage !== false ) {
            $newImageName = $this->uploadService->upload($projectImage);
            $projectImage = $newImageName;
        } else {
            $projectImage = $defaultImageName;
        }

        $project = new Project($request);
        $project->save();

        return $project;
    }

    public function update()
    {
        //... TODO
    }

}