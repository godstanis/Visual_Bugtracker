<?php

namespace App\Repositories;

use App\Project;

use Illuminate\Support\Facades\Storage;

class ProjectRepository
{
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
            
            if( $project->thumbnail_img !== $projectDefaultImageName){
                Storage::delete( $projectImageDirectory.'/'.$project->thumbnail_img );
            }

            if( $project->delete() and $project->project_access()->delete() )//$projectAccess->delete() )
            {
                event(new \App\Events\ProjectDeleted($project->id));
                $response['status'] = true;
            }

        }
    }

    public function create($data)
    {

        $projectImageDirectory = config('images.project_thumb_dir');
        $projectDefaultImageName = config('images.default_project_thumb');

        $uploadedImage = $data['project_image'];
        if($uploadedImage)
        {
            $imageExtension = $uploadedImage->getClientOriginalExtension();
            $newImageName = str_random(24) . uniqid() . '.' . $imageExtension;

            $thumbnail_img = $newImageName;

            Storage::put($projectImageDirectory.'/' . $thumbnail_img, file_get_contents($uploadedImage));
        }
        else
        {
            $thumbnail_img = $projectDefaultImageName;
        }

        $newProject = Project::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'creator_user_id' => $data['creator_user_id'],
            'thumbnail_img' => $thumbnail_img,
        ]);

        event(new \App\Events\ProjectCreated($newProject));

        $newProjectView = view('bugtracker.project-box', ['project' => $newProject])->render();

        return $newProjectView;
    }

    public function update()
    {
        //... TODO
    }

}