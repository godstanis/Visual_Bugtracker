<?php

namespace Tests\Feature;

use Faker\Factory as Faker;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegistrationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDisplaysRegistrationForm()
    {
        $this->get('/register')
            ->assertStatus(200)
            ->assertSee(__('auth.register'));
    }

    /**
     * A valid user information registration can be registered.
     *
     * @return void
     *
     * @depends testDisplaysRegistrationForm
     */
    public function testAValidUserRegisters()
    {
        $this->expectsEvents(\App\Events\UserRegistered::class);

        $faker = Faker::create();

        $password = $faker->password;

        $response = $this->post('/register', [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response->assertStatus(302);
    }

    /**
     * An invalid user information registration can not be registered.
     *
     * @return void
     *
     * @depends testDisplaysRegistrationForm
     */
    public function testAnInvalidUserDoesNotRegisters()
    {
        $faker = Faker::create();
        $password = $faker->password;

        $response = $this->post('/register', [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => $password,
            'password_confirmation' => $password.'invalid'
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors();
    }




}
