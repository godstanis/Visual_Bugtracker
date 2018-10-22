<?php

namespace App\Http\Controllers\Bugtracker;

use App\Http\Requests\BoardCreateForm;
use Illuminate\Http\Request;
use App\Http\Controllers\BugtrackerBaseController;

use App\Board;
use App\Project;

class BoardsController extends BugtrackerBaseController
{

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
     * @param BoardCreateForm $request
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(BoardCreateForm $request, Project $project)
    {
        $board = $project->boards()->create($request->all());

        if($request->ajax()) {
            return view('bugtracker.editor.partials.board-box', compact('board','project'));
        }

        return redirect()->back();
    }

    /**
     * Delete board.
     *
     * @param Request $request
     * @param Project $project
     * @param Board $board
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Project $project, Board $board)
    {
        $board->delete();

        if($request->ajax()) {
            return response("", 200);
        }

        return redirect()->back();
    }

    public function paths(Request $request, Project $project, Board $board)
    {
        $board->paths->load('creator');
        return new \App\Http\Resources\Path\PathCollection($board->paths);
    }

}
