<?php

namespace App\Services\FileUpload;

use Illuminate\Http\UploadedFile;

abstract class FileUploadContract
{
    protected $basePath;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public abstract function upload(UploadedFile $file, string $newName, string $oldName = null);
}