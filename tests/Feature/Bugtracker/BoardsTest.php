<?php

namespace Tests\Feature\Bugtracker;

use App\Board;
use App\Project;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BoardsTest extends TestCase
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

    public function setUp()
    {
        parent::setUp();

        Storage::fake();

        $this->user = factory(User::class)->create();

        $this->projectCreator = factory(User::class)->create();
        $this->projectMember = factory(User::class)->create();
        $this->project = factory(Project::class)->create(['user_id'=>$this->projectCreator]);
        $this->projectBoardsPage = '/tracker/project/' . $this->project->id . '/boards';

        $this->project->members()->attach($this->projectMember);

        Storage::fake();
    }

    public function testAGuestDoesNotSeeBoardsPage()
    {
        $response = $this->get($this->projectBoardsPage);
        $response->assertStatus(302);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\BoardsController::index()
     */
    public function testAValidUserSeesProjectBoardsPage()
    {

        $this->actingAs($this->projectCreator)->get($this->projectBoardsPage)
            ->assertStatus(200)
            ->assertSee(__('projects.create'));
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\BoardsController::create()
     */
    public function testAValidUserCreatesANewBoard()
    {
         $board = [
            'name' => $this->faker()->text(10),
            'image' => UploadedFile::fake()->image('board_image.png')
         ];

        $response = $this->actingAs($this->projectCreator)
            ->post($this->projectBoardsPage . '/create', $board);

        $response->assertStatus(302);

        $this->actingAs($this->projectCreator)->get($this->projectBoardsPage)
            ->assertSee($board['name']);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\BoardsController::delete()
     */
    public function testAValidUserDeletesHisBoard()
    {
        $board = [
            'name' => $this->faker()->text(10),
            'image' => UploadedFile::fake()->image('board_image.png')
        ];

        $createdBoard = $this->project->boards()->create(['user_id'=>$this->projectCreator->id]+$board);

        $this->actingAs($this->projectCreator)->get($this->projectBoardsPage)
            ->assertSee($board['name']);

        $this->actingAs($this->projectCreator)->get($this->projectBoardsPage . '/' . $createdBoard->id . '/delete')
            ->assertStatus(302);

        $this->actingAs($this->projectCreator)->get($this->projectBoardsPage)
            ->assertDontSee($board['name']);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\BoardsController::delete()
     */
    public function testAValidUserDoesNotDeleteAnotherUserBoard()
    {
        $board = [ // New board request data
            'name' => $this->faker()->text(10),
            'image' => UploadedFile::fake()->image('board_image.png')
        ];

        $this->project->members()->attach($this->user); // Attach a blank user to the project

        // Create a board as a blank user
        $createdBoard = $this->project->boards()->create(['user_id'=>$this->user->id]+$board);

        $this->actingAs($this->projectMember)->get($this->projectBoardsPage)
            ->assertSee($board['name']);


        // Try to delete other's board as a member, assert unauthorized (403)
        $this->actingAs($this->projectMember)->get($this->projectBoardsPage . '/' . $createdBoard->id . '/delete')
            ->assertStatus(403);

        $this->actingAs($this->projectMember)->get($this->projectBoardsPage)
            ->assertSee($board['name']);
    }


}
