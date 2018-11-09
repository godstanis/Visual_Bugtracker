<?php /** @noinspection PhpUndefinedClassInspection */

namespace Tests\Feature\Bugtracker;

use App\Project;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Bouncer;

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

    public function testACreatorSetsAbilityAndRevokesIt() {
        // Sets a manage ability
        $this->actingAs($this->creator)
            ->post($this->projectsTeamPage.'/allow', ['user'=>$this->member->name, 'ability_name' => 'manage'])
            ->assertStatus(200);

        $this->assertTrue($this->member->can('manage', $this->project));

        // Revokes a manage ability
        $this->actingAs($this->creator)
            ->post($this->projectsTeamPage.'/disallow', ['user'=>$this->member->name, 'ability_name' => 'manage'])
            ->assertStatus(200);

        Bouncer::refresh();
        $this->assertFalse($this->member->can('manage', $this->project));
    }

    public function testAManagerDoesNotSetAbilityAndDoesNotRevokeIt() {
        $this->member->allow('manage', $this->project);
        $this->project->members()->attach($this->user);

        // Tries to set a manage ability
        $this->actingAs($this->member)
            ->post($this->projectsTeamPage.'/allow', ['user'=>$this->user->name, 'ability_name' => 'manage'])
            ->assertStatus(403);

        $this->assertFalse($this->user->can('manage', $this->project));


        // Set the ability manually
        $this->user->allow('manage', $this->project);
        // Tries to revoke a manage ability
        $this->actingAs($this->member)
            ->post($this->projectsTeamPage.'/disallow', ['user'=>$this->user->name, 'ability_name' => 'manage'])
            ->assertStatus(403);

        Bouncer::refresh();
        $this->assertTrue($this->user->can('manage', $this->project));

    }

    public function testAMemberDoesNotSetAbilityAndDoesNotRevokeIt() {
        $this->project->members()->attach($this->user);

        // Tries to set a manage ability
        $this->actingAs($this->member)
            ->post($this->projectsTeamPage.'/allow', ['user'=>$this->user->name, 'ability_name' => 'manage'])
            ->assertStatus(403);

        $this->assertFalse($this->user->can('manage', $this->project));


        // Set the ability manually
        $this->user->allow('manage', $this->project);
        // Tries to revoke a manage ability
        $this->actingAs($this->member)
            ->post($this->projectsTeamPage.'/disallow', ['user'=>$this->user->name, 'ability_name' => 'manage'])
            ->assertStatus(403);

        Bouncer::refresh();
        $this->assertTrue($this->user->can('manage', $this->project));
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\TeamController::index()
     */
    public function testTeamPageDisplays()
    {
        $this->actingAs($this->creator)
            ->get($this->projectsTeamPage)
            ->assertStatus(200)
            ->assertSee($this->creator->name);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\TeamController::add()
     */
    public function testACreatorAddsMember()
    {
        $this->actingAs($this->creator)
            ->post($this->projectsTeamPage.'/attach', ['name'=>$this->user->name])
            ->assertStatus(302);

        $this->assertTrue($this->project->members->contains($this->user));
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\TeamController::remove()
     */
    public function testACreatorRemovesMember()
    {
        $this->actingAs($this->creator)
            ->post($this->projectsTeamPage.'/detach/'.$this->member->name)
            ->assertStatus(302);

        $this->assertFalse($this->project->members->contains($this->member));
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\TeamController::add()
     */
    public function testMemberDoesNotAddAnotherMember()
    {
        $this->actingAs($this->member)
            ->post($this->projectsTeamPage.'/attach', ['user_name'=>$this->user->name])
            ->assertStatus(403);

        $this->assertFalse($this->project->members->contains($this->user));
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\TeamController::remove()
     */
    public function testMemberDoesNotRemoveAnotherMember()
    {
        $this->project->members()->attach($this->user);

        $this->actingAs($this->member)
            ->post($this->projectsTeamPage.'/detach/'.$this->user->name)
            ->assertStatus(403);

        $this->assertTrue($this->project->members->contains($this->user));
    }
}
