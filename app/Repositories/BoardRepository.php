<?php

namespace App\Repositories;

use App\Board;
use App\Project;

use App\Services\FileUpload\AbstractFileUploadService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class BoardRepository
{
    protected $board;
    protected $uploadService;

    /**
     * ProjectRepository constructor.
     *
     * @param Board $board
     * @param AbstractFileUploadService $uploadService
     */
    public function __construct(Board $board, AbstractFileUploadService $uploadService)
    {
        $this->board = $board;
        $this->uploadService = $uploadService;
    }

    /**
     * Creates project.
     *
     * @param Project $project
     * @param $request
     * @return Model
     */
    public function create(Project $project, $request): Model
    {
        $boardImage = &$request['thumb_image'];

        $newImageName = $this->uploadService->upload($boardImage);
        $boardImage = $newImageName;

        return $project->boards()->create($request);
    }

    public function delete(Board $board): ?bool
    {
        $boardImageDirectory = config('images.boards_images_dir');

        if( $board ) {
            Storage::delete( $boardImageDirectory.'/'.$board->thumb_image );
            if( $board->delete() ) {
                return true;
            }
        }
    }

    public function update()
    {
        //... TODO
    }
}