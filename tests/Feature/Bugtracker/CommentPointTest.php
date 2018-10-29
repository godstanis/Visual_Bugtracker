<?php

namespace Tests\Feature\Bugtracker;

use App\Board;
use App\CommentPoint;
use App\Project;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentPointTest extends TestCase
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
    protected $boardCommentsPage;

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
        factory(CommentPoint::class, 4)->create(['user_id'=>$this->projectMember,'board_id'=>$this->board->id]);
        $this->projectBoardsPage = '/tracker/project/' . $this->project->id . '/editor/'.$this->board->id;

        $this->boardCommentsPage = $this->projectBoardsPage.'/comment_points';

    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\CommentPointController::index()
     */
    public function testCommentPointsCollectionIsShown()
    {
        $this->actingAs($this->projectMember)
            ->get($this->projectBoardsPage.'/comment_points')
            ->assertStatus(200)
            ->assertSee($this->board->commentPoints()->first()->id) // The first one
            ->assertSee($this->board->commentPoints()->latest()->first()->id); // The last one
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\CommentPointController::index()
     */
    public function testConcreteCommentPointJsonIsValid()
    {
        $firstPoint = $this->board->commentPoints()->with('issue', 'issue.project', 'creator')->first();

        $response = $this->actingAs($this->projectMember)
            ->get($this->boardCommentsPage )
            ->assertStatus(200);

        $response->assertJsonFragment([
            'id' => $firstPoint->id,
            'board_id' => $firstPoint->board_id,
            'text' => $firstPoint->text,
            'position_x' => $firstPoint->position_x,
            'position_y' => $firstPoint->position_y,
            'creator' => [
                'name' => $firstPoint->creator->name,
                'email' => $firstPoint->creator->email,
                'profile_image' => $firstPoint->creator->profile_image,
                'profile_image_link' => $firstPoint->creator->imageLink(),
                'url' => route('user', ['user_id'=>$firstPoint->creator->id]),
            ],
            'issue' => [
                'id' => $firstPoint->issue->id,
                'title' => $firstPoint->issue->title,
                'description' => $firstPoint->issue->description,
                'url' => route('project.issue.discussion', ['project_id'=>$firstPoint->issue->project_id, 'issue_id'=>$firstPoint->issue->id]),
            ]
        ]);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\CommentPointController::index()
     */
    public function testCommentPointsCollectionJsonIsValid()
    {
        $correctPathsCollectionOutput = [];

        // We will generate the correct json(array) response manually
        foreach($this->board->commentPoints as $point) {
            $correctPathsCollectionOutput[] = [
                'id' => $point->id,
                'board_id' => $point->board_id,
                'text' => $point->text,
                'position_x' => $point->position_x,
                'position_y' => $point->position_y,
                'creator' => [
                    'name' => $point->creator->name,
                    'email' => $point->creator->email,
                    'profile_image' => $point->creator->profile_image,
                    'profile_image_link' => $point->creator->imageLink(),
                    'url' => route('user', ['user_id'=>$point->creator->id]),
                ],
                'issue' => [
                    'id' => $point->issue->id,
                    'title' => $point->issue->title,
                    'description' => $point->issue->description,
                    'url' => route('project.issue.discussion', ['project_id'=>$point->issue->project_id, 'issue_id'=>$point->issue->id]),
                ]
            ];
        };

        $response = $this->actingAs($this->projectMember)
            ->get($this->boardCommentsPage )
            ->assertStatus(200);

        // The final output should match our manually generated one exactly
        $response->assertExactJson($correctPathsCollectionOutput);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\CommentPointController::index()
     */
    public function testCommentPointsAreNotShownForNotAMember()
    {
        $this->actingAs($this->user)
            ->get($this->boardCommentsPage )
            ->assertStatus(403);
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\CommentPointController::store()
     */
    public function testAMemberCreatesCommentPointWithNoIssueAssigned()
    {
        $comment = factory(CommentPoint::class)->make(); // Generating a random comment model (without saving)

        $this->actingAs($this->projectMember)
            ->post($this->boardCommentsPage, [
                'text' => $comment->text,
                'position_x' => $comment->position_x,
                'position_y' => $comment->position_y,
                'issue_id' => null
            ])
            ->assertStatus(200);

        $this->board->refresh();

        // Checking the existence of our new path in related table
        $this->assertTrue($this->board->commentPoints()->where([
            'text' => $comment->text,
            'position_x' => $comment->position_x,
            'position_y' => $comment->position_y,
            'issue_id' => null
        ])->exists());
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\CommentPointController::store()
     */
    public function testAMemberCreatesCommentPointWithIssueAssigned()
    {
        $comment = factory(CommentPoint::class)->make(); // Generating a random comment model (without saving)

        $issue = factory(\App\Issue::class)->create([
            'user_id' => $this->projectMember->id,
            'project_id' => $this->project->id
        ]);

        $this->actingAs($this->projectMember)
            ->post($this->boardCommentsPage, [
                'text' => $comment->text,
                'position_x' => $comment->position_x,
                'position_y' => $comment->position_y,
                'issue_id' => $issue->id
            ])
            ->assertStatus(200);

        $this->board->refresh();

        // Checking the existence of our new path in related table
        $this->assertTrue($this->board->commentPoints()->where([
            'text' => $comment->text,
            'position_x' => $comment->position_x,
            'position_y' => $comment->position_y,
            'issue_id' => $issue->id
        ])->exists());
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\CommentPointController::destroy()
     */
    public function testAMemberDeletesHisCommentPoint()
    {
        $commentPoint = $this->board->commentPoints()->where('user_id', $this->projectMember->id)->first();

        $this->actingAs($this->projectMember)
            ->delete($this->boardCommentsPage.'/'.$commentPoint->id)
            ->assertStatus(200);

        // Checking the existence of our new path in related table
        $this->assertTrue(! $this->board->commentPoints->contains($commentPoint));
    }

    /**
     * @covers \App\Http\Controllers\Bugtracker\CommentPointController::destroy()
     */
    public function testAMemberDoesNotDeleteACommentPointHeDidNotCreated()
    {
        $this->project->members()->attach($this->user);

        $commentPoint = $this->board->commentPoints()->where('user_id', $this->projectMember->id)->first();

        $this->actingAs($this->user)
            ->delete($this->boardCommentsPage.'/'.$commentPoint->id)
            ->assertStatus(403);
    }
}
