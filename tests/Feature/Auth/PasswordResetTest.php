<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Auth\Notifications\ResetPassword;

use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PasswordResetTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * The reset form can be displayed.
     *
     * @return void
     */
    public function testDisplaysEnterEmailToResetForm()
    {
        $this->get('/password/reset')
            ->assertStatus(200)
            ->assertSee(__('auth.password_reset'));
    }

    /**
     * The reset form can be displayed.
     *
     * @return void
     *
     * @depends testDisplaysEnterEmailToResetForm
     *
     * @covers \App\Http\Controllers\Auth\ResetPasswordController
     */
    public function testDisplaysResetPasswordForm()
    {
        $this->get('/password/reset/random_token')
            ->assertStatus(200)
            ->assertSee(__('auth.password_reset'));
    }

    /**
     * Password reset email sends when the user exists.
     *
     * @return void
     *
     * @depends testDisplaysResetPasswordForm
     */
    public function testSendsPasswordResetEmail()
    {
        $user = factory(User::class)->create();

        $this->expectsNotification($user, ResetPassword::class);

        $response = $this->post('password/email', ['email' => $user->email]);
        $response->assertStatus(302);
    }

    /**
     * Password reset email sends when the user exists.
     *
     * @return void
     *
     * @depends testDisplaysResetPasswordForm
     */
    public function testResetsUserPassword()
    {
        $user = factory(User::class)->create();

        $token = app('auth.password.broker')->createToken($user);

        $response = $this->post('/password/reset', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword'
        ]);

        $response->assertStatus(302);

        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
    }
}
