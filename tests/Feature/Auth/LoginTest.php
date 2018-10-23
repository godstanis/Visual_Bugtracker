<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    protected $loginPage = '/login';
    protected $logoutPage = '/logout';

    /**
     * The login form can be displayed.
     *
     * @return void
     */
    public function testUserIsGuest()
    {
        $this->assertTrue(auth()->guest());
    }

    /**
     * The login form can be displayed.
     *
     * @return void
     *
     * @depends testUserIsGuest
     *
     * @covers \App\Http\Controllers\Auth\LoginController
     */
    public function testDisplaysLoginForm()
    {
        $this->get($this->loginPage)
            ->assertStatus(200)
            ->assertSee(__('auth.login'));
    }

    /**
     * A valid user can be logged in.
     *
     * @return void
     *
     * @depends testUserIsGuest
     * @depends testDisplaysLoginForm
     */
    public function testValidActivatedUserLogsIn()
    {
        $validUser = factory(User::class)
            ->states('activated')
            ->create();

        $response = $this->post($this->loginPage, [
            'email' => $validUser->email,
            'password' => 'secret'
        ]);

        $response->assertStatus(302);

        $this->assertAuthenticatedAs($validUser);
    }

    /**
     * A valid, but not activated user account can not be logged in.
     *
     * @return void
     *
     * @depends testUserIsGuest
     * @depends testDisplaysLoginForm
     */
    public function testValidNotActivatedUserDoesNotLogIn()
    {
        $notActivatedUser = factory(User::class)
            ->states('not_activated')
            ->create();

        $response = $this->post($this->loginPage, [
            'email' => $notActivatedUser->email,
            'password' => 'secret'
        ]);

        $response->assertStatus(302)
            ->assertSessionHas('warning');

        $this->assertGuest();
    }

    /**
     * Invalid user can not be logged in.
     *
     * @return void
     *
     * @depends testUserIsGuest
     * @depends testDisplaysLoginForm
     */
    public function testInvalidUserDoesNotLogin()
    {
        $invalidUser = factory(User::class)
            ->states('activated')
            ->create();

        $response = $this->post($this->loginPage, [
            'email' => $invalidUser->email,
            'password' => 'invalid_password'
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors();

        $this->assertGuest();
    }

    /**
     * An authenticated valid user can be logged out.
     *
     * @return void
     *
     * @depends testUserIsGuest
     * @depends testDisplaysLoginForm
     */
    public function testAuthenticatedUserCanLogOut()
    {
        $validUser = factory(User::class)
            ->states('activated')
            ->create();

        $response = $this->actingAs($validUser)->post($this->logoutPage);

        $response->assertStatus(302);

        $this->assertGuest();
    }

    /**
     * A guest can not be logged out.
     *
     * @return void
     *
     * @depends testUserIsGuest
     * @depends testDisplaysLoginForm
     */
    public function testAGuestDoesNotLogsOut()
    {
        $response = $this->post($this->logoutPage);

        $response->assertStatus(302);

        $this->assertGuest();
    }
}
