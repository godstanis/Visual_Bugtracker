<?php

namespace App\Repositories;

use App\User;

use Illuminate\Support\Facades\Storage;

class UserRepository
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function updateUserImage(\Illuminate\Http\UploadedFile $image)
    {

        $imageExtension = $image->getClientOriginalExtension();
        $newImageName = uniqid() . '.' . $imageExtension;

        $oldUserImage = $this->user->profile_image;
        $this->user->profile_image = $newImageName;

        if( $this->user->update() )
        {
            define( 'AVATARS_DIRECTORY', config('images.user_avatar_dir') );
            define( 'DEFAULT_AVATAR_NAME', config('images.default_user_avatar') );

            Storage::disk('s3')
                ->put( AVATARS_DIRECTORY.'/' . $this->user->profile_image, file_get_contents($image) );

            if( $oldUserImage !== DEFAULT_AVATAR_NAME){
                Storage::disk('s3')->delete( AVATARS_DIRECTORY.'/'.$oldUserImage );
            }
        }
    }

}