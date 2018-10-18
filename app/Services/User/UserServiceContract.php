<?php

namespace App\Services\User;

use App\User;

use App\Services\FileUpload\FileUploadContract;
use Illuminate\Http\UploadedFile;

abstract class UserServiceContract
{
    protected $user;
    protected $uploadService;

    /**
     * UserRepository constructor.
     * @param User $user
     * @param FileUploadContract $uploadService
     */
    public function __construct(User $user, FileUploadContract $uploadService)
    {
        $this->user = $user;
        $this->uploadService = $uploadService;
    }

    /**
     * Updates user avatar image.
     *
     * @param UploadedFile $image
     * @return void
     */
    public abstract function updateUserImage(UploadedFile $image): void;
}