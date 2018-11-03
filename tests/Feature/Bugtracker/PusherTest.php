<?php

namespace Tests\Feature\Bugtracker;

use App\Board;
use App\Project;
use App\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PusherTest extends TestCase
{
    use WithFaker;
    /**
     * @var \App\User A blank user for advanced manipulations.
     */
    protected $user;

    protected $project;
    protected $projectCreator;
    protected $projectMember;

    protected $board;
    protected $pusherAuthRoute;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->projectCreator = factory(User::class)->create();
        $this->projectMember = factory(User::class)->create();
        $this->project = factory(Project::class)->create(['user_id'=>$this->projectCreator]);

        $this->project->members()->attach($this->projectMember);

        $this->board = factory(Board::class)->create(['project_id' => $this->project->id, 'user_id' => $this->projectCreator]);

        $this->pusherAuthRoute = '/pusher-auth';
    }

    /**
     * @covers \App\Custom\Pusher\Channels\BoardChannel
     */
    public function testAValidUserAuthorizesToTheBoardChannel()
    {
        $validUsers = [$this->projectCreator, $this->projectMember];
        foreach($validUsers as $user) {
            $this->actingAs($user)->post($this->pusherAuthRoute, [
                'channel_name' => 'private-board_' . $this->board->id,
            ])->assertStatus(200);
        }
    }

    /**
     * @covers \App\Custom\Pusher\Channels\BoardChannel
     */
    public function testAUserThatHasNoAccessToTheBoardDoesNotAuthorizesToTheBoardChannel()
    {
        // A blank user (with no access to the board) tries to authorize to board's private channel
        $this->actingAs($this->user)->post($this->pusherAuthRoute, [
            'channel_name' => 'private-board_' . $this->board->id,
        ])->assertStatus(403);
    }
}
