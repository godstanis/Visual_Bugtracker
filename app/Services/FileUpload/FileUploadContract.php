<?php

namespace App\Services\FileUpload;

use Illuminate\Http\UploadedFile;

abstract class FileUploadContract
{
    protected $basePath;

    /**
     * FileUploadContract constructor.
     * @param string $basePath File destination path.
     */
    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @param UploadedFile $file
     * @param string $newName
     * @param string|null $oldName Defines a file name to be deleted/stashed.
     * @return mixed
     */
    public abstract function upload(UploadedFile $file, string $newName, string $oldName = null): void;
}