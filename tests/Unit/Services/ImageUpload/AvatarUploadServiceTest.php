<?php

namespace Tests\Unit\Services\ImageUpload;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\ImageUpload\AvatarUploadService;

class AvatarUploadServiceTest extends TestCase
{
    protected $avatarUploadService;

    public function setUp()
    {
        $this->createApplication();
        $this->avatarUploadService = new AvatarUploadService(config('images.user_avatar_dir'));
        Storage::fake('s3');
    }

    /**
     * @covers AvatarUploadService::upload()
     */
    public function testUploadsImage()
    {
        $newProfileImage = UploadedFile::fake()->image('new_avatar.jpg');

        $uploadedImageName = $this->avatarUploadService->upload($newProfileImage);
        $imagePath = config('images.user_avatar_dir') . '/' . $uploadedImageName;

        Storage::disk('s3')->assertExists($imagePath);
    }


    /**
     * @depends testUploadsImage
     * @covers AvatarUploadService::delete()
     */
    public function testDeletesImage()
    {
        $newProfileImage = UploadedFile::fake()->image('new_avatar.jpg');

        $uploadedImageName = $this->avatarUploadService->upload($newProfileImage);
        $imagePath = config('images.user_avatar_dir') . '/' . $uploadedImageName;

        Storage::disk('s3')->assertExists($imagePath);
        $isDeleted = $this->avatarUploadService->delete($uploadedImageName);
        $this->assertTrue($isDeleted);

        Storage::disk('s3')->assertMissing($imagePath);
    }
}
