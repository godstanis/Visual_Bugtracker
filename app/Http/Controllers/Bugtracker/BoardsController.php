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

    /**
     * BoardsController constructor.
     *
     * @param BoardRepository $repository
     */
    public function __construct(BoardRepository $repository)
    {
        $this->board_repository = $repository;
    }

    /**
     * Show all boards, assigned to the project.
     *
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Project $project)
    {
        $boards = $project->boards;

        return view('bugtracker.project.boards', compact('boards', 'project'));
    }

    /**
     * Create board, and store it in DataBase.
     *
     * @param \App\Http\Requests\BoardCreateForm $request
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(\App\Http\Requests\BoardCreateForm $request, Project $project)
    {
        $board = $this->board_repository->create($project, $request->all());

        return view('bugtracker.editor.partials.board-box', compact('board','project'));
    }

    /**
     * Delete board.
     *
     * @param Project $project
     * @param Board $board
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Project $project, Board $board)
    {
        $this->board_repository->delete($board);

        return redirect()->back();
    }

}
