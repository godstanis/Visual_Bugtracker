<?php

namespace Tests\Feature\Bugtracker;

use App\Issue;
use App\Project;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IssueDiscussionTest extends TestCase
{

    use WithFaker,
        DatabaseTransactions;

    /**
     * @var \App\User A blank user for advanced manipulations.
     */
    protected $user;

    protected $project;
    protected $projectCreator;
    protected $projectMember;

    protected $issue;
    protected $issueCreator;

    protected $issuePageRoute;
    protected $issueDiscussionPage;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->projectCreator = factory(User::class)->create();
        $this->projectMember = factory(User::class)->create();
        $this->issueCreator = factory(User::class)->create();

        $this->project = factory(Project::class)->create(['user_id'=>$this->projectCreator]);
        $this->project->members()->attach($this->projectMember);
        $this->project->members()->attach($this->issueCreator);

        $this->issue = factory(Issue::class)->create(['project_id'=>$this->project->id, 'user_id'=>$this->issueCreator->id]);

        $this->issuePageRoute = '/tracker/project/' . $this->project->id . '/issues/' . $this->issue->id;
        $this->issueDiscussionPage =$this->issuePageRoute . '/discussion';
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssueDiscussionController::getDiscussion()
     */
    public function testIssueDiscussionPageDisplays()
    {
        $this->actingAs($this->projectCreator)
            ->get($this->issueDiscussionPage)
            ->assertStatus(200)
            ->assertSee($this->issue->title);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\IssueDiscussionController::createMessage()
     */
    public function testAValidUserCreatesAMessage()
    {
        $discussionMessage = [
            'text' => $this->faker()->text(255)
        ];
        $this->actingAs($this->projectMember)
            ->post($this->issueDiscussionPage, $discussionMessage)
            ->assertStatus(302);

        $this->actingAs($this->projectMember)->get($this->issueDiscussionPage)->assertSee($discussionMessage['text']);
    }

}
