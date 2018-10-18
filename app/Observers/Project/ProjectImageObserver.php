<?php

namespace App\Observers\Project;

use App\Project;
use App\Services\FileUpload\AbstractFileUploadService;

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
        $image = request()->thumbnail_img;

        if( ! isset( $image ) ) {
            $project->thumbnail_img = config('images.default_project_thumb');
            return;
        }

        $project->thumbnail_img = $this->uploadService->upload($image);
    }

    /**
     * Handle the project "deleted" event and delete the project image from disk.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function deleted(Project $project)
    {
        $this->uploadService->delete($project->thumbnail_img);
    }

}
