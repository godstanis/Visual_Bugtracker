<?php

namespace Tests\Unit\Services\User;

use App\Services\ImageUpload\AvatarUploadService;
use App\Services\User\UserService;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
    use WithFaker;

    protected $user;
    protected $fileUploadService;

    protected $userService;

    public function setUp()
    {
        $this->createApplication();

        $this->fileUploadService = new AvatarUploadService(config('images.user_avatar_dir'));
        $this->user = factory(\App\User::class)->create();
        $this->userService = new UserService(
            $this->user,
            $this->fileUploadService
        );
    }

    /**
     * @covers UserService::updateUserImage()
     */
    public function testUpdatesUserImage()
    {
        $newAvatarName = 'new_avatar.jpg';
        $newProfileImage = UploadedFile::fake()->image($newAvatarName);

        $this->userService->updateUserImage($newProfileImage, $newAvatarName);

        $this->assertEquals($this->user->profile_image, $newAvatarName);
    }
}
