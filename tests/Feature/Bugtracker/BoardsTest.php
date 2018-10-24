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

    protected $validUser;
    protected $projectCreatedByAValidUser;

    protected $anotherUser;
    protected $projectCreatedByAnotherUser;

    protected $projectBoardsPage;
    protected $anotherProjectBoardsPage;

    public function setUp()
    {
        parent::setUp();

        $this->validUser = factory(User::class)->create();
        $this->projectCreatedByAValidUser = factory(Project::class)->create(['user_id'=>$this->validUser]);
        $this->projectBoardsPage = '/tracker/project/' . $this->projectCreatedByAValidUser->id . '/boards';

        $this->anotherUser = factory(User::class)->create();
        $this->projectCreatedByAnotherUser = factory(Project::class)->create(['user_id'=>$this->anotherUser]);
        $this->anotherProjectBoardsPage = '/tracker/project/' . $this->projectCreatedByAnotherUser->id . '/boards';

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

        $this->actingAs($this->validUser)->get($this->projectBoardsPage)
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

        $response = $this->actingAs($this->validUser)
            ->post($this->projectBoardsPage . '/create', $board);

        $response->assertStatus(302);

        $this->actingAs($this->validUser)->get($this->projectBoardsPage)
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

        $createdBoard = $this->projectCreatedByAValidUser->boards()->create(['user_id'=>$this->validUser->id]+$board);

        $this->actingAs($this->validUser)->get($this->projectBoardsPage)
            ->assertSee($board['name']);

        $this->actingAs($this->validUser)->get($this->projectBoardsPage . '/' . $createdBoard->id . '/delete')
            ->assertStatus(302);

        $this->actingAs($this->validUser)->get($this->projectBoardsPage)
            ->assertDontSee($board['name']);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\BoardsController::delete()
     */
    public function testAValidUserDoesNotDeleteAnotherUserBoard()
    {
        $board = [
            'name' => $this->faker()->text(10),
            'image' => UploadedFile::fake()->image('board_image.png')
        ];

        $this->projectCreatedByAnotherUser->members()->attach($this->validUser);

        $createdBoard = $this->projectCreatedByAnotherUser->boards()->create(['user_id'=>$this->anotherUser->id]+$board);

        $this->actingAs($this->validUser)->get($this->anotherProjectBoardsPage)
            ->assertSee($board['name']);

        $this->actingAs($this->validUser)->get($this->anotherProjectBoardsPage . '/' . $createdBoard->id . '/delete')
            ->assertStatus(403);

        $this->actingAs($this->validUser)->get($this->anotherProjectBoardsPage)
            ->assertSee($board['name']);
    }
}
