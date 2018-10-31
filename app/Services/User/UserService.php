<?php

namespace App\Services\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Mockery\Exception;

class UserService extends AbstractUserService
{
    protected $user;
    protected $uploadService;

    /**
     * Updates user avatar image.
     *
     * @param UploadedFile $image
     * @param string $imageName
     * @return void
     */
    public function updateUserImage(UploadedFile $image, string $imageName = ''): void
    {
        $oldImageName = $this->user->profile_image;

        $newImageName = ($imageName !== '')?$imageName:uniqid('', false) . '.png';

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
