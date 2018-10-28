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

    protected $creator;
    protected $project;
    protected $member;
    protected $user;


    public function setUp()
    {
        parent::setUp();
        $this->creator = factory(User::class)->create();
        $this->member = factory(User::class)->create();
        $this->user = factory(User::class)->create();
        $this->project = factory(Project::class)->create(['user_id'=>$this->creator->id]);
        $this->project->members()->attach($this->member);
    }

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
        $projectSettingsPage = '/tracker/project/'.$this->project->id.'/settings';

        $response = $this->actingAs($this->creator)->get($projectSettingsPage);

        $response->assertStatus(200)
            ->assertSee($this->project->name)
            ->assertSee($this->project->description);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\ProjectsController::getAvailableProjects()
     */
    public function testAnAuthenticatedUserSeesProjectsHeCreated()
    {
        $response = $this->actingAs($this->creator)->get($this->projectsPage);
        $response->assertStatus(200)
            ->assertSee($this->project->name)
            ->assertSee($this->project->description);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\ProjectsController::getAvailableProjects()
     */
    public function testAnAuthenticatedUserDoesNotSeeProjectsHeDidNotCreateAndHasNoMembership()
    {
        $response = $this->actingAs($this->user)->get($this->projectsPage);
        $response->assertStatus(200)
            ->assertDontSee($this->project->name)
            ->assertDontSee($this->project->description);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\ProjectsController::getAvailableProjects()
     */
    public function testAnAuthenticatedUserSeesProjectsHeHasMembershipIn()
    {
        $response = $this->actingAs($this->member)->get($this->projectsPage);
        $response->assertStatus(200);

        $response->assertSeeText($this->project->name);
        $response->assertSeeText($this->project->description);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\ProjectsController::postCreateProject()
     */
    public function testAnAuthenticatedUserCreatesANewProject()
    {
        $projectName = $this->faker()->name;
        $projectDescription = $this->faker()->text(255);

        $response = $this->actingAs($this->user)->post($this->createProjectRoute, [
            'name' => $projectName,
            'description' => $projectDescription
        ]);

        $response->assertStatus(302);

        $this->actingAs($this->user)->get($this->projectsPage)
            ->assertSee($projectName)
            ->assertSee($projectDescription);

    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\ProjectsController::postUpdateProject()
     */
    public function testAnAuthenticatedUserUpdatesHisProject()
    {
        $newName = $this->faker()->name;
        $newDescription = $this->faker()->text(255);

        $projectSettingsRoute = '/tracker/project/'.$this->project->id.'/settings';

        $response = $this->actingAs($this->creator)->post($projectSettingsRoute, [
            'name' => $newName,
            'description' => $newDescription
        ]);

        $response->assertStatus(302);

        $this->actingAs($this->creator)->get($this->projectsPage)
            ->assertSee($newName)
            ->assertSee($newDescription);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\ProjectsController::postDeleteProject()
     */
    public function testAnAuthenticatedUserDeletesHisProject()
    {
        $deleteProjectRoute = '/tracker/project/'.$this->project->id.'/delete';

        $response = $this->actingAs($this->creator)->post($deleteProjectRoute);

        $response->assertStatus(302);

        $this->actingAs($this->creator)->get($this->projectsPage)
            ->assertDontSee($this->project->name)
            ->assertDontSee($this->project->description);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\ProjectsController::postDeleteProject()
     */
    public function testAnAuthenticatedUserDoesNotDeleteAProjectHeHasMembershipIn()
    {
        $deleteProjectRoute = '/tracker/project/'.$this->project->id.'/delete';

        $response = $this->actingAs($this->member)->post($deleteProjectRoute);

        $response->assertStatus(403);

        $this->actingAs($this->creator)->get($this->projectsPage)
            ->assertSee($this->project->name)
            ->assertSee($this->project->description);
    }


}
