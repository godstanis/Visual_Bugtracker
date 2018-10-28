<?php

namespace App\Observers\Project;

use App\Project;
use App\Services\ImageUpload\AbstractFileUploadService;

class ProjectImageObserver
{
    /**
     * @var AbstractFileUploadService
     */
    private $uploadService;

    function __construct(AbstractFileUploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
     * Handle the project "creating" event and upload an image to disk.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function creating(Project $project)
    {
        $image = request()->image;

        if( ! isset( $image ) ) {
            $project->image = config('images.default_project_thumb');
            return;
        }

        $project->image = $this->uploadService->upload($image);
    }

    /**
     * Handle the project "updating" event and upload an image to disk.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function updating(Project $project)
    {
        $image = request()->image;

        if( isset( $image ) ) {
            $project->image = $this->uploadService->upload($image);
        }
    }

    /**
     * Handle the project "deleted" event and delete the project image from disk.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function deleted(Project $project)
    {
        $this->uploadService->delete($project->image);
    }

}
