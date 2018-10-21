<?php

namespace App\Services\ImageUpload;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager as Image;

class ProjectImageUploadService extends AbstractFileUploadService
{
    protected $defaultProjectImageName;

    /**
     * AvatarUploadContract constructor.
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        parent::__construct($basePath);
        $this->defaultProjectImageName = config('images.default_project_thumb');
    }

    /**
     * @param UploadedFile $file
     * @param string $newName
     * @param string|null $oldName
     * @return string  $newName
     */
    public function upload(UploadedFile $file, string $newName = null, string $oldName = null) :string
    {
        if($newName === null) {
            $imageExtension = $file->getClientOriginalExtension();
            $newName = str_random(24) . uniqid("", false) . '.' . $imageExtension;
        }

        $uploadedImage = (new Image)->make($file)->resize(null,150, function ($constraint) {
            $constraint->aspectRatio();
        });

        Storage::put($this->basePath.'/' . $newName, (string)$uploadedImage->stream());

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
        if($name !== $this->defaultProjectImageName) {
            Storage::delete($this->basePath . '/' . $name);
        }
        return true;
    }
}
