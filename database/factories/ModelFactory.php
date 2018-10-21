<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker, array $params) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'profile_image' => config('images.default_user_avatar'),
        'activated' => false,
    ];
});

$factory->state(App\User::class, 'activated', function (Faker\Generator $faker) {
    return [
        'activated' => true
    ];
});

$factory->state(App\User::class, 'not_activated', function (Faker\Generator $faker) {
    return [
        'activated' => false
    ];
});


$factory->define(App\Project::class, function (Faker\Generator $faker) {
    return [
        'name' => str_random(14),
        'description' => str_random(300),
        'creator_user_id' => function(){
            return factory(App\User::class)->create()->id;
        },
        'thumbnail_img' => str_random(100),
    ];
});


$factory->define(App\Issue::class, function (Faker\Generator $faker, array $params) {
    return [
        'project_id' => $params['project_id'],
        'title' => str_random(20),
        'description' => str_random(100),
        'created_by_user_id' => 1,
        'priority_id' => 1,
        'type_id' => 1,
        'assigned_to_user_id' => 1
    ];
});