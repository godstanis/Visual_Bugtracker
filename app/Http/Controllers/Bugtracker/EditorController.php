<?php

namespace App\Http\Controllers\Bugtracker;

use Illuminate\Http\Request;
use App\Http\Controllers\BugtrackerBaseController;

use App\Project;
use App\Path;
use App\Board;

class EditorController extends BugtrackerBaseController
{
    public function getEditor(Request $request, Project $project, Board $board)
    {
        $boards = $project->boards;

        $current_board = null;


        if($board->id !== null)
        {


            if( ! auth()->user()->can('view', $board) )
            {
                abort(404);
            }


            $current_board = $board;
        }
        
        return view('bugtracker.editor.main', ['project'=>$project, 'boards'=>$boards, 'current_board'=>$current_board]);
    }

}
