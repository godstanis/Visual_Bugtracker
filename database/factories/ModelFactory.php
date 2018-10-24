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
        'activated' => true,
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


$factory->define(App\Project::class, function (Faker\Generator $faker, array $params) {
    return [
        'name' => str_random(14),
        'description' => str_random(255),
        'user_id' => isset($params['user_id'])? $params['user_id']:factory(App\User::class)->create()->id,
        'image' => str_random(100),
    ];
});


$factory->define(App\Issue::class, function (Faker\Generator $faker, array $params) {
    return [
        'project_id' => isset($params['project_id'])? $params['project_id']:factory(App\Project::class)->create()->id,
        'title' => str_random(20),
        'description' => str_random(100),
        'user_id' => isset($params['user_id'])? $params['user_id']:factory(App\User::class)->create()->id,
        'priority_id' => 1,
        'type_id' => 1
    ];
});

$factory->define(App\Board::class, function (Faker\Generator $faker, array $params) {
    return [
        'project_id' => isset($params['project_id'])? $params['project_id']:factory(App\Project::class)->create()->id,
        'user_id' => isset($params['user_id'])? $params['user_id']:factory(App\User::class)->create()->id,
        'name' => str_random(8),
        'image' => isset($params['image'])? $params['image']:$faker->text(20),
    ];
});