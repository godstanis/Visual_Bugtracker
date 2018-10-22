<?php

namespace App\Http\Controllers\Bugtracker;

use App\Http\Requests\BoardEditorRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\BugtrackerBaseController;

use App\Project;
use App\Path;
use App\Board;

class EditorController extends BugtrackerBaseController
{

    /**
     * Return the editor page.
     *
     * @param BoardEditorRequest $request
     * @param Project $project
     * @param Board $board
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBoardEditor(BoardEditorRequest $request, Project $project, Board $board)
    {
        $project->boards->load('creator');
        return view('bugtracker.editor.main', ['project'=>$project, 'boards'=>$project->boards, 'current_board'=>$board]);
    }

}
