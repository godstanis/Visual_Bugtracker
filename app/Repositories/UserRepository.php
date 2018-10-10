<?php

namespace App\Repositories;

use App\User;

use App\Services\FileUpload\FileUploadContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Mockery\Exception;

class UserRepository
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
     */
    public function updateUserImage(UploadedFile $image)
    {
        $oldImageName = $this->user->profile_image;

        $newImageName = uniqid("", false) . '.png';
        $this->user->profile_image = $newImageName;

        try {
            DB::transaction(function(){
                $this->user->update();
            });
            $this->uploadService->upload($image, $newImageName, $oldImageName);
        } catch (Exception $e) {
            abort(503, $e->getMessage());
        }
    }

}
