<?php

use App\Project;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultProject = [
            'name' => 'BugWall',
            'description' => 'BugWall is a visual bugtracking system.',
            'creator_user_id' => 1,
            'thumbnail_img' => 'default.jpg',
            'website_url' => route('home')
        ];

        factory(Project::class)->create($defaultProject);
    }
}
