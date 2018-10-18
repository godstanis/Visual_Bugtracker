<?php

namespace App\Services\FileUpload;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager as Image;

class BoardImageUploadService extends AbstractFileUploadService
{
    protected $basePath;

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
}