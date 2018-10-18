<?php

namespace App\Services\User;

use App\User;

use App\Services\FileUpload\AbstractFileUploadService;
use Illuminate\Http\UploadedFile;

abstract class AbstractUserService
{
    protected $user;
    protected $uploadService;

    /**
     * UserRepository constructor.
     * @param User $user
     * @param AbstractFileUploadService $uploadService
     */
    public function __construct(User $user, AbstractFileUploadService $uploadService)
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
