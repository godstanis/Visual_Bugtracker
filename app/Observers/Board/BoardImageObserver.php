<?php

namespace App\Observers\Board;

use App\Board;
use App\Services\ImageUpload\AbstractFileUploadService;

class BoardImageObserver
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
     * Handle the board "creating" event.
     *
     * @param  \App\Board  $board
     * @return void
     */
    public function creating(Board $board)
    {
        $image = request()->thumb_image;
        $board->thumb_image = $this->uploadService->upload($image);
    }

    /**
     * Handle the board "deleted" event.
     *
     * @param  \App\Board  $board
     * @return void
     */
    public function deleted(Board $board)
    {
        $this->uploadService->delete($board->thumb_image);
    }
}
