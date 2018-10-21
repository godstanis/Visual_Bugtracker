<?php

namespace App\Services\ImageUpload;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager as Image;

class BoardImageUploadService extends AbstractFileUploadService
{

    /**
     * BoardImageUploadContract constructor.
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        parent::__construct($basePath);
    }

    /**
     * @param UploadedFile $file
     * @param string $newName
     * @param string|null $oldName
     * @return string $newName
     */
    public function upload(UploadedFile $file, string $newName = null, string $oldName = null) :string
    {
        if($newName === null) {
            $imageExtension = $file->getClientOriginalExtension();
            $newName = str_random(24) . uniqid("", false) . '.' . $imageExtension;
        }

        Storage::put($this->basePath . '/' . $newName, file_get_contents( $file ));

        return $newName;
    }

    /**
     * @param UploadedFile $file
     * @param string $newName
     * @param string|null $oldName Defines a file name to be deleted/stashed.
     * @return bool
     */
    public function delete(string $name): bool
    {
        Storage::delete( $this->basePath . '/' . $name );
        return true;
    }
}
