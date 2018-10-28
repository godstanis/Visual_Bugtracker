<?php

namespace Tests\Feature\Bugtracker;

use App\Project;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /**
     * @var \App\User A blank user for advanced manipulations.
     */
    protected $user;

    protected $creator;
    protected $member;
    protected $project;
    protected $projectsTeamPage;

    public function setUp()
    {
        parent::setUp();
        $this->creator = factory(User::class)->create();
        $this->member = factory(User::class)->create();
        $this->user = factory(User::class)->create();
        $this->project = factory(Project::class)->create(['user_id'=>$this->creator->id]);
        $this->project->members()->attach($this->member);
        $this->projectsTeamPage = '/tracker/project/' . $this->project->id . '/team';
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\TeamController::getAllTeamMembers()
     */
    public function testTeamPageDisplays()
    {
        $this->actingAs($this->creator)
            ->get($this->projectsTeamPage)
            ->assertStatus(200)
            ->assertSee(__('projects.team_creator_badge'));
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\TeamController::postAddMember()
     */
    public function testACreatorAddsMember()
    {
        $this->actingAs($this->creator)
            ->post($this->projectsTeamPage.'/attach', ['user_name'=>$this->user->name])
            ->assertStatus(302);

        $this->actingAs($this->creator)->get($this->projectsTeamPage)->assertSee($this->user->name);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\TeamController::getRemoveMember()
     */
    public function testACreatorRemovesMember()
    {
        $this->actingAs($this->creator)
            ->get($this->projectsTeamPage.'/deattach/'.$this->member->name)
            ->assertStatus(302);

        $this->actingAs($this->creator)->get($this->projectsTeamPage)->assertDontSee($this->member->name);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\TeamController::postAddMember()
     */
    public function testMemberDoesNotAddAnotherMember()
    {
        $this->actingAs($this->member)
            ->post($this->projectsTeamPage.'/attach', ['user_name'=>$this->user->name])
            ->assertStatus(403);

        $this->actingAs($this->member)->get($this->projectsTeamPage)->assertDontSee($this->user->name);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\TeamController::getRemoveMember()
     */
    public function testMemberDoesNotRemoveAnotherMember()
    {
        $this->project->members()->attach($this->user);

        $this->actingAs($this->member)
            ->get($this->projectsTeamPage.'/deattach/'.$this->user->name)
            ->assertStatus(403);

        $this->actingAs($this->creator)->get($this->projectsTeamPage)->assertSee($this->user->name);
    }
}
