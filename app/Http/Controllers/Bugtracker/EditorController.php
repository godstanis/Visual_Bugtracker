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

    public function getBoardEditor(BoardEditorRequest $request, Project $project, Board $board)
    {
        return view('bugtracker.editor.main', ['project'=>$project, 'boards'=>$project->boards, 'current_board'=>$board]);
    }

}
