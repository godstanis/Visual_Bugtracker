<?php

namespace Tests\Feature\Bugtracker;

use Faker\Factory as Faker;

use App\Project;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectsTest extends TestCase
{
    use WithFaker,
        DatabaseTransactions;

    protected $projectsPage = '/tracker/projects';
    protected $createProjectRoute = '/tracker/projects/create';

    public function testAGuestDoesNotSeeProjectsPage()
    {
        $response = $this->get($this->projectsPage);
        $response->assertStatus(302);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\ProjectsController::getSettingsPage()
     */
    public function testAnAuthenticatedUserSeesProjectSettingsPageOfHisProject()
    {
        $validUser = factory(User::class)->create();

        $projectCreatedByUser = factory(Project::class)
            ->create(['user_id'=>$validUser->id]);

        $projectSettingsPage = '/tracker/project/'.$projectCreatedByUser->id.'/settings';

        $response = $this->actingAs($validUser)->get($projectSettingsPage);

        $response->assertStatus(200)
            ->assertSee($projectCreatedByUser->name)
            ->assertSee($projectCreatedByUser->description);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\ProjectsController::getAvailableProjects()
     */
    public function testAnAuthenticatedUserSeesProjectsHeCreated()
    {
        $validUser = factory(User::class)->create();

        $projectCreatedByUser = factory(Project::class)
            ->create(['user_id'=>$validUser->id]);

        $response = $this->actingAs($validUser)->get($this->projectsPage);
        $response->assertStatus(200)
            ->assertSee($projectCreatedByUser->name)
            ->assertSee($projectCreatedByUser->description);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\ProjectsController::getAvailableProjects()
     */
    public function testAnAuthenticatedUserSeesProjectsHeHasMembershipIn()
    {
        $validUser = factory(User::class)->create();
        $otherUser = factory(User::class)->create();

        $projectCreatedByOtherUser = factory(Project::class)
            ->create(['user_id'=>$otherUser->id]);

        $projectCreatedByOtherUser->members()->attach($validUser);

        $response = $this->actingAs($validUser)->get($this->projectsPage);
        $response->assertStatus(200);

        $response->assertSeeText($projectCreatedByOtherUser->name);
        $response->assertSeeText($projectCreatedByOtherUser->description);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\ProjectsController::postCreateProject()
     */
    public function testAnAuthenticatedUserCreatesANewProject()
    {
        $validUser = factory(User::class)->create();

        $createdProjectName = $this->faker()->name;
        $createdProjectDescription = $this->faker()->text(255);

        $response = $this->actingAs($validUser)->post($this->createProjectRoute, [
            'name' => $createdProjectName,
            'description' => $createdProjectDescription
        ]);

        $response->assertStatus(302);

        $this->actingAs($validUser)->get($this->projectsPage)
            ->assertSee($createdProjectName)
            ->assertSee($createdProjectDescription);

    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\ProjectsController::postUpdateProject()
     */
    public function testAnAuthenticatedUserUpdatesHisProject()
    {
        $validUser = factory(User::class)->create();

        $newName = $this->faker()->name;
        $newDescription = $this->faker()->text(255);

        $projectCreatedByUser = factory(Project::class)
            ->create(['user_id'=>$validUser->id]);

        $projectSettingsRoute = '/tracker/project/'.$projectCreatedByUser->id.'/settings';

        $response = $this->actingAs($validUser)->post($projectSettingsRoute, [
            'name' => $newName,
            'description' => $newDescription
        ]);

        $response->assertStatus(302);

        $this->actingAs($validUser)->get($this->projectsPage)
            ->assertSee($newName)
            ->assertSee($newDescription);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\ProjectsController::postDeleteProject()
     */
    public function testAnAuthenticatedUserDeletesHisProject()
    {
        $validUser = factory(User::class)->create();

        $projectCreatedByUser = factory(Project::class)
            ->create(['user_id'=>$validUser->id]);

        $deleteProjectRoute = '/tracker/project/'.$projectCreatedByUser->id.'/delete';

        $response = $this->actingAs($validUser)->post($deleteProjectRoute);

        $response->assertStatus(302);

        $this->actingAs($validUser)->get($this->projectsPage)
            ->assertDontSee($projectCreatedByUser->name)
            ->assertDontSee($projectCreatedByUser->description);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\ProjectsController::postDeleteProject()
     */
    public function testAnAuthenticatedUserDoesNotDeleteAProjectHeHasMembershipIn()
    {
        $validUser = factory(User::class)->create();
        $otherUser = factory(User::class)->create();

        $projectCreatedByOtherUser = factory(Project::class)
            ->create(['user_id'=>$otherUser->id]);

        $projectCreatedByOtherUser->members()->attach($validUser);

        $deleteProjectRoute = '/tracker/project/'.$projectCreatedByOtherUser->id.'/delete';

        $response = $this->actingAs($validUser)->post($deleteProjectRoute);

        $response->assertStatus(403);

        $this->actingAs($validUser)->get($this->projectsPage)
            ->assertSee($projectCreatedByOtherUser->name)
            ->assertSee($projectCreatedByOtherUser->description);
    }


}
