<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    protected $authenticatedUser = null;

    /**
     * Create a user instance with db row once for all tests
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if($this->authenticatedUser == null)
        {
            $this->authenticatedUser = factory(\App\User::class)->create();
        }
    }


    /**
     * The user page of valid user can be displayed.
     *
     * @return void
     *
     * @covers \App\Http\Controllers\User\UserController::getUserPage()
     */
    public function testValidUserPageDisplayed()
    {
        $viewedUser = factory(\App\User::class)->create(); // creating a user model with a db row

        $authenticatedUser = $this->authenticatedUser;

        $this->actingAs($authenticatedUser)
            ->get('/user/' . $viewedUser->name)
            ->assertStatus(200)
            ->assertSee($viewedUser->name)
            ->assertSee($viewedUser->email);
    }

    /**
     * The user page of invalid user can not be displayed.
     *
     * @return void
     *
     * @covers \App\Http\Controllers\User\UserController::getUserPage()
     */
    public function testInvalidUserPageDisplayDenied()
    {
        $viewedUser = factory(\App\User::class)->make(); // creating a user model without a db row

        $authenticatedUser = $this->authenticatedUser;

        $this->actingAs($authenticatedUser)
            ->get('/user/' . $viewedUser->name)
            ->assertStatus(404);
    }

    /**
     * The user page can not be displayed for guests.
     *
     * @return void
     *
     * @covers \App\Http\Controllers\User\UserController::getUserPage()
     */
    public function testGuestUserPageDisplayDenied()
    {
        $viewedUser = factory(\App\User::class)->create(); // creating a user model with a db row

        $this->get('/user/' . $viewedUser->name)
            ->assertStatus(302)
            ->assertDontSee($viewedUser->name)
            ->assertDontSee($viewedUser->email);
    }

    /**
     * The settings page can be displayed for a valid authenticated user.
     *
     * @return void
     *
     * @covers \App\Http\Controllers\User\UserController::getUserSettings()
     */
    public function testValidUserSettingsPageDisplayed()
    {
        $authenticatedUser = $this->authenticatedUser;

        $this->actingAs($authenticatedUser)
            ->get('/user/settings')
            ->assertStatus(200)
            ->assertSee($authenticatedUser->name)
            ->assertSee($authenticatedUser->email);
    }

    /**
     * The settings page can not be displayed for a guest.
     *
     * @return void
     *
     * @covers \App\Http\Controllers\User\UserController::getUserSettings()
     */
    public function testGuestUserSettingsPageDisplayDenied()
    {
       $this->get('/user/settings')
            ->assertStatus(302);
    }

    /**
     * User can change his profile image.
     *
     * @return void
     *
     * @covers \App\Http\Controllers\User\UserController::postUserProfileImage()
     */
    public function testUserChangesHisProfileImage()
    {
        $authenticatedUser = $this->authenticatedUser;

        $oldUserProfileImage = $authenticatedUser->profile_image;
        $newProfileImage = UploadedFile::fake()->image('new_avatar.jpg');

        Storage::fake('s3');

        $this->actingAs($authenticatedUser)
            ->post('/user', [
                'profile_image' => $newProfileImage
            ]);

        $this->assertNotEquals($oldUserProfileImage, $newProfileImage);

        $imagePath = config('images.user_avatar_dir') . '/' . $authenticatedUser->profile_image;
        Storage::disk('s3')->assertExists($imagePath);

    }


}
