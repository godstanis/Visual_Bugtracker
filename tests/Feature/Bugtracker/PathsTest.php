<?php

namespace Tests\Feature\Bugtracker;

use App\Board;
use App\Path;
use App\Project;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PathsTest extends TestCase
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
    protected $projectBoardsPage;

    protected $board;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->projectCreator = factory(User::class)->create();
        $this->projectMember = factory(User::class)->create();
        $this->project = factory(Project::class)->create(['user_id'=>$this->projectCreator]);
        $this->project->members()->attach($this->projectMember);

        $this->board = factory(Board::class)->create([
            'user_id'=>$this->projectMember->id,
            'project_id'=>$this->project->id
        ]);
        factory(Path::class, 4)->create(['user_id'=>$this->projectMember,'board_id'=>$this->board->id]);
        $this->projectBoardsPage = '/tracker/project/' . $this->project->id . '/editor/'.$this->board->id;

    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\PathController::all()
     */
    public function testPathsCollectionIsShown()
    {
        $this->actingAs($this->projectMember)
            ->get($this->projectBoardsPage.'/paths')
            ->assertStatus(200)
            ->assertSee($this->board->paths()->first()->path_slug) // The first one
            ->assertSee($this->board->paths()->latest()->first()->path_slug); // The last one
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\PathController::all()
     */
    public function testConcretePathJsonIsValid()
    {
        $firstPath = $this->board->paths()->first();

        $response = $this->actingAs($this->projectMember)
            ->get($this->projectBoardsPage.'/paths')
            ->assertStatus(200);

        $response->assertJsonFragment([
            'path_slug' => $firstPath->path_slug,
            'stroke' => $firstPath->stroke_color,
            'stroke-width' => $firstPath->stroke_width,
            'd' => $firstPath->path_data,
            'info' => [
                'creator_id' => $firstPath->creator->id
            ]
        ]);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\PathController::all()
     */
    public function testPathsCollectionJsonIsValid()
    {
        $correctPathsCollectionOutput = [];

        // We will generate the correct json(array) response manually
        foreach($this->board->paths as $path) {
            $correctPathsCollectionOutput[] = [
                'path_slug' => $path->path_slug,
                'stroke' => $path->stroke_color,
                'stroke-width' => $path->stroke_width,
                'd' => $path->path_data,
                'info' => [
                    'creator_id' => $path->creator->id
                ]
            ];
        };

        $response = $this->actingAs($this->projectMember)
            ->get($this->projectBoardsPage.'/paths')
            ->assertStatus(200);

        // The final output should match our manually generated one exactly
        $response->assertExactJson($correctPathsCollectionOutput);

    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\PathController::all()
     */
    public function testPathsAreNotShownForNotAMember()
    {
        $this->actingAs($this->user)
            ->get($this->projectBoardsPage.'/paths')
            ->assertStatus(403);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\PathController::create()
     */
    public function testAMemberDrawsAPath()
    {
        $path = factory(Path::class)->make(); // Generating a random path model (without saving)

        $this->actingAs($this->projectMember)
            ->post($this->projectBoardsPage.'/create-path', [
                'path_data' => $path->path_data,
                'stroke_width' => $path->stroke_width,
                'stroke_color' => $path->stroke_color
            ])
            ->assertStatus(201);

        $this->board->refresh();

        // Checking the existence of our new path in related table
        $this->assertTrue($this->board->paths()->where([
            'path_data' => $path->path_data,
            'stroke_width' => $path->stroke_width,
            'stroke_color' => $path->stroke_color
        ])->exists());
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\PathController::destroy()
     */
    public function testAPathCreatorDeletesHisPaths()
    {
        $membersPath = $this->board->paths->where('user_id', $this->projectMember->id)->first();
        $this->actingAs($this->projectMember)
            ->post($this->projectBoardsPage.'/delete-path', [
                'path_slug' => $membersPath->path_slug
            ])
            ->assertStatus(302);

        // Checking the existence of our new path in related table
        $this->assertTrue(! $this->board->paths()->where([
            'path_data' => $membersPath->path_data,
            'stroke_width' => $membersPath->stroke_width,
            'stroke_color' => $membersPath->stroke_color
        ])->exists());
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\PathController::destroy()
     */
    public function testAMemberDoesNotDeleteAPathHeDidNotCreated()
    {
        $membersPath = $this->board->paths->where('user_id', $this->projectMember->id)->first();
        $this->project->members()->attach($this->user); // Attach a new member

        // A new member tries to delete other's member path
        $this->actingAs($this->user)
            ->post($this->projectBoardsPage.'/delete-path', [
                'path_slug' => $membersPath->path_slug
            ])
            ->assertStatus(403);

        // Checking the existence of our new path in related table
        $this->assertTrue($this->board->paths()->where([
            'path_data' => $membersPath->path_data,
            'stroke_width' => $membersPath->stroke_width,
            'stroke_color' => $membersPath->stroke_color
        ])->exists());
    }

}
