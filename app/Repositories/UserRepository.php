<?php

namespace App\Repositories;

use App\User;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Mockery\Exception;

class UserRepository
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param UploadedFile $image
     */
    public function updateUserImage(UploadedFile $image)
    {

        $newImageName = uniqid("", false) . '.' . $image->getClientOriginalExtension();
        $currentUserAvatarName = $this->user->profile_image;
        $avatarsDirectory = config('images.user_avatar_dir');
        $defaultAvatarName = config('images.default_user_avatar');

        $this->user->profile_image = $newImageName;

        try{
            $this->user->update();

            Storage::disk('s3')
                ->put( $avatarsDirectory .'/' . $this->user->profile_image, file_get_contents($image) );

            if( $currentUserAvatarName !== $defaultAvatarName){
                Storage::disk('s3')->delete( $avatarsDirectory . '/' . $currentUserAvatarName );
            }
        }
        catch(Exception $e){
            abort(503, $e->getMessage());
        }

    }

}