<?php

namespace App\Http\Controllers\Bugtracker;

use Illuminate\Http\Request;
use App\Http\Controllers\BugtrackerBaseController;

use App\Board;
use App\Project;

use App\Repositories\BoardRepository;

class BoardsController extends BugtrackerBaseController
{

    protected $board_repository;

    public function __construct(BoardRepository $repository)
    {
        $this->board_repository = $repository;
    }

    /*
     * Show all boards, assigned to the project
    */
    public function getProjectBoards(Project $project)
    {
        $boards = $project->boards;

        return view('bugtracker.project.boards', ['boards' => $boards, 'project'=>$project] );
    }

    /*
     * Create board, and store it in DataBase
    */
    public function postCreateBoard(\App\Http\Requests\BoardCreateForm $request, Project $project)
    {

        $board_repository = $this->board_repository;

        $data = [
            'project_id' => $project->id,
            'name' => 'My board',
            'created_by_user_id' => auth()->user()->id,
            'thumb_image' => $request->file('board_image'),
        ];

        $board = $board_repository->create($data);

        return view('bugtracker.project.partials.board-box', compact('board','project'));
        
    }

    public function postDeleteBoard(Project $project, Board $board)
    {

        $board_repository = $this->board_repository;
        
        $board_repository->delete($board);

        return redirect()->back();
    }

}
