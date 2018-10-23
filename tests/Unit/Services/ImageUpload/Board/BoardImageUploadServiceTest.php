<?php

namespace Tests\Unit\Services\ImageUpload\Board;

use App\Services\ImageUpload\Board\BoardImageUploadService;
use App\Services\ImageUpload\Board\BoardThumbnailDecorator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BoardImageUploadServiceTest extends TestCase
{
    protected $boardImageUploadService;
    protected $boardImageUploadServiceWithThumbnail;

    public function setUp()
    {
        $this->createApplication();
        $this->boardImageUploadService = new BoardImageUploadService(config('images.project_thumb_dir'));
        $this->boardImageUploadServiceWithThumbnail = new BoardThumbnailDecorator(
            config('images.project_thumb_dir'),
            $this->boardImageUploadService,
            'prefix_');
        Storage::fake('s3');
    }

    /**
     * @covers BoardImageUploadService::upload()
     */
    public function testUploadsImage()
    {
        $newBoardImage = UploadedFile::fake()->image('new_avatar.jpg');

        $uploadedImageName = $this->boardImageUploadService->upload($newBoardImage);
        $imagePath = config('images.project_thumb_dir') . '/' . $uploadedImageName;

        Storage::disk('s3')->assertExists($imagePath);
    }


    /**
     * @depends testUploadsImage
     * @covers BoardImageUploadService::delete()
     */
    public function testDeletesImage()
    {
        $newBoardImage = UploadedFile::fake()->image('new_avatar.jpg');

        $uploadedImageName = $this->boardImageUploadService->upload($newBoardImage);
        $imagePath = config('images.project_thumb_dir') . '/' . $uploadedImageName;

        Storage::disk('s3')->assertExists($imagePath);
        $isDeleted = $this->boardImageUploadService->delete($uploadedImageName);
        $this->assertTrue($isDeleted);

        Storage::disk('s3')->assertMissing($imagePath);
    }

    /**
     * @covers BoardThumbnailDecorator::upload()
     */
    public function testThumbnailBoardImageDecoratorCreatesThumbnailImage()
    {
        $newBoardImage = UploadedFile::fake()->image('new_avatar.jpg');

        $uploadedImageName = $this->boardImageUploadServiceWithThumbnail->upload($newBoardImage);
        $fullSizedImagePath = config('images.project_thumb_dir') . '/' . $uploadedImageName;
        $thumbnailImagePath = config('images.project_thumb_dir') . '/' . 'prefix_'.$uploadedImageName;

        Storage::disk('s3')->assertExists($fullSizedImagePath);
        Storage::disk('s3')->assertExists($thumbnailImagePath);
    }

    /**
     * @covers BoardThumbnailDecorator::delete()
     */
    public function testThumbnailBoardImageDecoratorDeletesThumbnailImage()
    {
        $newBoardImage = UploadedFile::fake()->image('new_avatar.jpg');

        $uploadedImageName = $this->boardImageUploadServiceWithThumbnail->upload($newBoardImage);
        $imagePath = config('images.project_thumb_dir') . '/' . $uploadedImageName;
        $thumbnailImagePath = config('images.project_thumb_dir') . '/' . 'prefix_'.$uploadedImageName;

        Storage::disk('s3')->assertExists($imagePath);
        Storage::disk('s3')->assertExists($thumbnailImagePath);

        $isDeleted = $this->boardImageUploadServiceWithThumbnail->delete($uploadedImageName);
        $this->assertTrue($isDeleted);

        Storage::disk('s3')->assertMissing($imagePath);
        Storage::disk('s3')->assertMissing($thumbnailImagePath);
    }
}
