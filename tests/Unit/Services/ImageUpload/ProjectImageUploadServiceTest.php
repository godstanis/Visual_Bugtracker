<?php

namespace Tests\Unit\Services\ImageUpload;

use App\Services\ImageUpload\ProjectImageUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectImageUploadServiceTest extends TestCase
{
    protected $projectImageUploadService;

    public function setUp()
    {
        $this->createApplication();
        $this->projectImageUploadService = new ProjectImageUploadService(config('images.project_thumb_dir'));
        Storage::fake('s3');
    }

    /**
     * @covers ProjectImageUploadService::upload()
     */
    public function testUploadsImage()
    {
        $newProjectImage = UploadedFile::fake()->image('new_avatar.jpg');

        $uploadedImageName = $this->projectImageUploadService->upload($newProjectImage);
        $imagePath = config('images.project_thumb_dir') . '/' . $uploadedImageName;

        Storage::disk('s3')->assertExists($imagePath);
    }


    /**
     * @depends testUploadsImage
     * @covers ProjectImageUploadService::delete()
     */
    public function testDeletesImage()
    {
        $newProjectImage = UploadedFile::fake()->image('new_avatar.jpg');

        $uploadedImageName = $this->projectImageUploadService->upload($newProjectImage);
        $imagePath = config('images.project_thumb_dir') . '/' . $uploadedImageName;

        Storage::disk('s3')->assertExists($imagePath);
        $isDeleted = $this->projectImageUploadService->delete($uploadedImageName);
        $this->assertTrue($isDeleted);

        Storage::disk('s3')->assertMissing($imagePath);
    }
}
