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
    /*
    protected $validUser;
    protected $project;
    protected $projectIssuesPage;

    protected $anotherUser;
    protected $anotherUserProject;
    protected $anotherProjectIssuesPage;
    */

    /**
     * @var \App\User A blank user for advanced manipulations.
     */
    protected $user;

    protected $project;
    protected $projectCreator;
    protected $projectMember;

    protected $baseProjectPage;
    protected $projectIssuesPage;

    protected $issue;
    protected $issueCreator;
    protected $issuePageRoute;

    public function setUp()
    {
        parent::setUp();

        $this->baseProjectPage = '/tracker/project/';

        $this->user = factory(User::class)->create();

        $this->projectCreator = factory(User::class)->create();
        $this->projectMember = factory(User::class)->create();
        $this->project = factory(Project::class)->create(['user_id'=>$this->projectCreator]);
        $this->projectIssuesPage = $this->baseProjectPage . $this->project->id . '/issues';

        $this->project->members()->attach($this->projectMember);

        $this->issueCreator = factory(User::class)->create();
        $this->project->members()->attach($this->issueCreator);
        $this->issue = factory(Issue::class)->create(['project_id'=>$this->project->id, 'user_id'=>$this->issueCreator->id]);
        $this->issuePageRoute = '/tracker/project/' . $this->project->id . '/issues/' . $this->issue->id;
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssuesController::getProjectIssues()
     */
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
        $this->actingAs($this->projectCreator)->get($this->projectIssuesPage)
            ->assertStatus(200)->assertSee( __('projects.issue_create') );
        $this->actingAs($this->projectMember)->get($this->projectIssuesPage)
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

        $this->actingAs($this->projectCreator)->post($createIssueRoute, $newIssue)->assertStatus(302);

        $this->actingAs($this->projectCreator)->get($this->projectIssuesPage)
            ->assertSee($newIssue['title']);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssuesController::getDeleteIssue()
     */
    public function testAValidUserDeletesHisIssue()
    {
        $issueUserCreated = factory(Issue::class)
            ->create([
                'user_id' => $this->projectMember->id,
                'project_id' => $this->project->id
            ]);

        $deleteIssueRoute = $this->projectIssuesPage . '/' . $issueUserCreated->id . '/delete';

        $this->actingAs($this->projectMember)->get($deleteIssueRoute)->assertStatus(302);

        $this->actingAs($this->projectMember)->get($this->projectIssuesPage)
            ->assertDontSee($issueUserCreated->title);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssuesController::getDeleteIssue()
     */
    public function testAValidUserDoesNotDeleteIssueHeHasNoAccessToDelete()
    {
        $this->project->members()->attach($this->user);

        $issueUserCreated = factory(Issue::class)
            ->create([
                'user_id' => $this->user->id,
                'project_id' => $this->project->id
            ]);

        $this->actingAs($this->user)->get($this->projectIssuesPage)
            ->assertSee($issueUserCreated->title);

        $deleteIssueRoute = $this->projectIssuesPage . '/' . $issueUserCreated->id . '/delete';

        $this->actingAs($this->projectMember)->get($deleteIssueRoute)->assertStatus(403);

        $this->actingAs($this->projectMember)->get($this->projectIssuesPage)
            ->assertSee($issueUserCreated->title);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssuesController::attachUser()
     */
    public function testAValidUserDoesAttachAMemberToHisIssue()
    {
        $this->project->members()->attach($this->user);

        $issueUserCreated = factory(Issue::class)
            ->create([
                'user_id' => $this->projectMember->id,
                'project_id' => $this->project->id
            ]);

        $attachUserRoute = $this->projectIssuesPage . '/' . $issueUserCreated->id . '/attach/' . $this->user->name;

        $this->actingAs($this->projectMember)->get($attachUserRoute)->assertStatus(302);

        $this->assertTrue($issueUserCreated->assignees->contains($this->user));
    }


    /**
     * @covers \App\Http\Controllers\Bugtracker\IssuesController::attachUser()
     */
    public function testAValidUserDoesNotAttachAMemberToTheIssueHeDidNotCreated()
    {
        $this->project->members()->attach($this->user);

        $issueUserCreated = factory(Issue::class)
            ->create([
                'user_id' => $this->projectCreator->id,
                'project_id' => $this->project->id
            ]);

        $attachUserRoute = $this->projectIssuesPage . '/' . $issueUserCreated->id . '/attach/' . $this->user->name;

        // Another project member tries to add another member to the issue, created by project creator
        $this->actingAs($this->projectMember)->get($attachUserRoute)->assertStatus(403);

        $this->assertFalse($issueUserCreated->assignees->contains($this->user));
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssuesController::closeIssue()
     */
    public function testIssueCreatorClosesIssue()
    {
        $closeIssueRoute = $this->issuePageRoute . '/close';

        $this->actingAs($this->issueCreator)->post($closeIssueRoute)->assertStatus(302);
        $this->issue->refresh();

        $this->assertTrue($this->issue->closed);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssuesController::closeIssue()
     */
    public function testIssueAssignedUserClosesIssue()
    {
        $this->issue->assignees()->attach($this->projectMember);

        $closeIssueRoute = $this->issuePageRoute . '/close';
        $this->actingAs($this->projectMember)->post($closeIssueRoute)->assertStatus(302);
        $this->issue->refresh();
        $this->assertTrue($this->issue->closed);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssuesController::closeIssue()
     */
    public function testNotAssignedUserDoesNotCloseIssue()
    {
        $closeIssueRoute = $this->issuePageRoute . '/close';
        $this->actingAs($this->projectMember)->post($closeIssueRoute)->assertStatus(403);
        $this->issue->refresh();
        $this->assertFalse($this->issue->closed);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssuesController::attachUser()
     */
    public function testTheCreatorDoesAssignOtherMember()
    {
        $assignMemberRoute = $this->issuePageRoute . '/attach/';

        $this->actingAs($this->projectCreator)->get($assignMemberRoute . $this->projectMember->name)->assertStatus(302);
        $this->issue->refresh();
        $this->assertTrue($this->issue->assignees->contains($this->projectMember));
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssuesController::attachUser()
     */
    public function testNotACreatorDoesNotAssignOtherMembers()
    {
        $this->project->members()->attach($this->user);
        $this->issue->assignees()->attach($this->projectMember);

        $assignMemberRoute = $this->issuePageRoute . '/attach/';

        $this->actingAs($this->projectMember)->get($assignMemberRoute . $this->user->name)->assertStatus(403);
        $this->issue->refresh();
        $this->assertFalse($this->issue->assignees->contains($this->projectCreator));
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssuesController::attachUser()
     */
    public function testNotACreatorDoesAssignHimself()
    {
        $assignMemberRoute = $this->issuePageRoute . '/attach/';

        $this->actingAs($this->projectMember)->get($assignMemberRoute . $this->projectMember->name)->assertStatus(302);
        $this->issue->refresh();
        $this->assertTrue($this->issue->assignees->contains($this->projectMember));
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssuesController::detachUser()
     */
    public function testAnAssignedUserDeAssignHimself()
    {
        $assignMemberRoute = $this->issuePageRoute . '/detach/';

        $this->actingAs($this->projectMember)->get($assignMemberRoute . $this->projectMember->name)->assertStatus(302);
        $this->issue->refresh();
        $this->assertFalse($this->issue->assignees->contains($this->projectMember));
    }

}
