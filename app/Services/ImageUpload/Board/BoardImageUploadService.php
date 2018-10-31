<?php

namespace App\Services\ImageUpload\Board;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager as Image;
use App\Services\ImageUpload\AbstractFileUploadService;

class BoardImageUploadService extends AbstractFileUploadService
{

    protected $maxSize = 2060;

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

        $uploadedImage = $this->optimizeImageSize($file);

        Storage::put($this->basePath . '/' . $newName, (string)$uploadedImage->stream());

        return $newName;
    }

    /**
     * If an image is too big - we will reduce it's size.
     *
     * @param UploadedFile $uploadedFile
     * @return \Intervention\Image\Image
     */
    public function optimizeImageSize(UploadedFile $uploadedFile): \Intervention\Image\Image
    {
        $image = (new Image)->make($uploadedFile);

        if($image->width() > $this->maxSize)
        {
            $image->resize($this->maxSize, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } elseif($image->height() > $this->maxSize) {
            $image->resize(null, $this->maxSize, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        return $image;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function delete(string $name): bool
    {
        Storage::delete( $this->basePath . '/' . $name );
        return true;
    }
}
