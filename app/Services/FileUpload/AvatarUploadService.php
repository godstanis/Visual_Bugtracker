<?php


namespace App\Services\FileUpload;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager as Image;

class AvatarUploadService extends FileUploadContract
{
    protected $defaultAvatarName;

    /**
     * AvatarUploadContract constructor.
     * @param $basePath
     */
    public function __construct($basePath)
    {
        parent::__construct($basePath);
        $this->defaultAvatarName = config('images.default_user_avatar');
    }

    public function upload(UploadedFile $file, string $newName, string $oldName = null)
    {
        $uploadedImage = (new Image)->make($file)->resize(150,150);

        $avatarsDirectory = $this->basePath;
        $defaultAvatarName = $this->defaultAvatarName;

        Storage::put(
            $avatarsDirectory .'/' . $newName,
            (string)$uploadedImage->stream()
        ); // save new avatar

        if( $oldName !== $defaultAvatarName){
            Storage::delete( $avatarsDirectory . '/' . $oldName ); // delete old avatar
        }
    }
}