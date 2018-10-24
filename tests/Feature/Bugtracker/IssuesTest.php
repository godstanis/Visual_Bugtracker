<?php

namespace Tests\Feature\Bugtracker;

use App\Issue;
use App\Project;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IssuesTest extends TestCase
{
    use WithFaker,
        DatabaseTransactions;

    protected $validUser;
    protected $projectCreatedByAValidUser;
    protected $projectIssuesPage;

    protected $anotherUser;
    protected $projectCreatedByAnotherUser;
    protected $anotherProjectIssuesPage;

    public function setUp()
    {
        parent::setUp();

        $this->validUser = factory(User::class)->create();
        $this->projectCreatedByAValidUser = factory(Project::class)
            ->create(['user_id'=>$this->validUser]);
        $this->projectIssuesPage = '/tracker/project/' . $this->projectCreatedByAValidUser->id . '/issues';

        $this->anotherUser = factory(User::class)->create();
        $this->projectCreatedByAnotherUser = factory(Project::class)
            ->create(['user_id'=>$this->anotherUser]);
        $this->anotherProjectIssuesPage = '/tracker/project/' . $this->projectCreatedByAnotherUser->id . '/issues';

    }

    public function testAGuestDoesNotSeeIssuesPage()
    {
        $response = $this->get($this->projectIssuesPage);
        $response->assertStatus(302);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssuesController::getProjectIssues()
     */
    public function testUserSeesIssuesPage()
    {
        $this->actingAs($this->validUser)->get($this->projectIssuesPage)
            ->assertStatus(200)->assertSee( __('projects.issue_create') );
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssuesController::postCreateIssue()
     */
    public function testAValidUserCreatesIssue()
    {
        $createIssueRoute = $this->projectIssuesPage . '/create';

        $newIssue = [
            'title' => $this->faker()->text(10),
            'description' => $this->faker()->text(40),
            'type_id' => 1,
            'priority_id' => 1
        ];

        $this->actingAs($this->validUser)->post($createIssueRoute, $newIssue)->assertStatus(302);

        $this->actingAs($this->validUser)->get($this->projectIssuesPage)
            ->assertSee($newIssue['title']);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssuesController::getDeleteIssue()
     */
    public function testAValidUserDeletesHisIssue()
    {
        $issueUserCreated = factory(Issue::class)
            ->create([
                'user_id' => $this->validUser->id,
                'project_id' => $this->projectCreatedByAValidUser->id
            ]);

        $deleteIssueRoute = $this->projectIssuesPage . '/' . $issueUserCreated->id . '/delete';

        $this->actingAs($this->validUser)->get($deleteIssueRoute)->assertStatus(302);

        $this->actingAs($this->validUser)->get($this->projectIssuesPage)
            ->assertDontSee($issueUserCreated->title);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssuesController::getDeleteIssue()
     */
    public function testAValidUserDoesNotDeleteIssueHeHasNoAccessToDelete()
    {
        $issueUserCreated = factory(Issue::class)
            ->create([
                'user_id' => $this->anotherUser->id,
                'project_id' => $this->projectCreatedByAnotherUser->id
            ]);

        $otherUsersProjectIssuesPage = '/tracker/project/' . $this->projectCreatedByAnotherUser->id . '/issues';

        $this->projectCreatedByAnotherUser->members()->attach($this->validUser);

        $this->actingAs($this->validUser)->get($otherUsersProjectIssuesPage)
            ->assertSee($issueUserCreated->title);

        $deleteIssueRoute = $otherUsersProjectIssuesPage . '/' . $issueUserCreated->id . '/delete';

        $this->actingAs($this->validUser)->get($deleteIssueRoute)->assertStatus(403);

        $this->actingAs($this->validUser)->get($otherUsersProjectIssuesPage)
            ->assertSee($issueUserCreated->title);
    }

    public function testAValidUserDoesAttachAMemberToHisIssue()
    {
        $issueUserCreated = factory(Issue::class)
            ->create([
                'user_id' => $this->validUser->id,
                'project_id' => $this->projectCreatedByAValidUser->id
            ]);
        $this->projectCreatedByAValidUser->members()->attach($this->anotherUser);
        $attachUserRoute = $this->projectIssuesPage . '/' . $issueUserCreated->id . '/attach/' . $this->anotherUser->name;

        $this->actingAs($this->validUser)->get($attachUserRoute)->assertStatus(302);

        $this->assertTrue($issueUserCreated->assignees->contains($this->anotherUser));
    }


    public function testAValidUserDoesNotAttachAMemberToTheIssueHeNotCreated()
    {
        $issueUserCreated = factory(Issue::class)
            ->create([
                'user_id' => $this->anotherUser->id,
                'project_id' => $this->projectCreatedByAnotherUser->id
            ]);
        $this->projectCreatedByAnotherUser->members()->attach($this->validUser);
        $attachUserRoute = $this->projectIssuesPage . '/' . $issueUserCreated->id . '/attach/' . $this->anotherUser->name;

        $this->actingAs($this->validUser)->get($attachUserRoute)->assertStatus(403);

        $this->assertFalse($issueUserCreated->assignees->contains($this->anotherUser));
    }

}
