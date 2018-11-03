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
        'name' => $faker->unique()->name,
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
        'user_id' => $params['user_id'] ?? factory(App\User::class)->create()->id,
        'image' => str_random(100),
    ];
});


$factory->define(App\Issue::class, function (Faker\Generator $faker, array $params) {
    $project = factory(App\Project::class)->create();
    $user = factory(App\User::class)->create();
    $project->members()->attach($user);

    return [
        'project_id' => $params['project_id'] ?? $project->id,
        'user_id' => $params['user_id'] ?? $user->id,
        'title' => str_random(20),
        'description' => str_random(100),
        'priority_id' => 1,
        'type_id' => 1
    ];
});

$factory->define(App\IssueDiscussion::class, function (Faker\Generator $faker, array $params) {
    return [
        'project_id' => $params['project_id'] ?? factory(App\Project::class)->create()->id,
        'issue_id' => $params['issue_id'] ?? factory(App\Issue::class)->create()->id,
        'user_id' => $params['user_id'] ?? factory(App\User::class)->create()->id,
        'text' => str_random(100)
    ];
});

$factory->define(App\Board::class, function (Faker\Generator $faker, array $params) {
    return [
        'project_id' => $params['project_id'] ?? factory(App\Project::class)->create()->id,
        'user_id' => $params['user_id'] ?? factory(App\User::class)->create()->id,
        'name' => str_random(8),
        'image' => $params['image'] ?? $faker->text(20),
    ];
});

$factory->define(App\Path::class, function (Faker\Generator $faker, array $params) {
    if(!function_exists('generatePath')) {
        // Generates a valid random path data
        function generatePath() {
            $iterations = random_int(1,10);
            $pathData = "M".random_int(1,250).",".random_int(1,250);

            for($i = 0; $i <= $iterations; $i++) {
                $pathData .= "L".random_int(1,250).",".random_int(1,250);
            }

            return $pathData;
        }
    }

    return [
        'board_id' => $params['board_id'] ?? factory(App\Board::class)->create()->id,
        'user_id' => $params['user_id'] ?? factory(App\User::class)->create()->id,
        // Generates random valid hex color, example: #14FAD2
        'stroke_color' => '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6),
        'stroke_width' => random_int(1,10),
        'path_data' => $params['path_data'] ?? generatePath(),
    ];
});

$factory->define(App\CommentPoint::class, function (Faker\Generator $faker, array $params) {
    return [
        'board_id' => $params['board_id'] ?? factory(App\Board::class)->create()->id,
        'user_id' => $params['user_id'] ?? factory(App\User::class)->create()->id,
        'issue_id' => $params['issue_id'] ?? factory(App\Issue::class)->create()->id,
        // Generates random valid hex color, example: #14FAD2
        'position_x' => random_int(1,100),
        'position_y' => random_int(1,100),
        'text' => str_random(40)
    ];
});
