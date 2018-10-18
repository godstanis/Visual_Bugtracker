<?php

namespace App\Services\User;

use App\User;

use App\Services\FileUpload\FileUploadContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Mockery\Exception;

class UserService extends UserServiceContract
{
    protected $user;
    protected $uploadService;

    /**
     * Updates user avatar image.
     *
     * @param UploadedFile $image
     * @return void
     */
    public function updateUserImage(UploadedFile $image): void
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