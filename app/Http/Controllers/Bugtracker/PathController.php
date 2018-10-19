<?php

namespace App\Http\Controllers\Bugtracker;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Project;
use App\Board;

class PathController extends Controller
{


    public function savePath(Request $request, Project $project, Board $board)
    {
        $path = $board->paths()->create($request->all());

        if($request->ajax()) {
            $response = [ 'path_slug' => $path->path_slug ];
            return response(json_encode($response), 200);
        }

        return redirect()->back();
    }

    public function deletePath(Request $request, Project $project, Board $board)
    {
        $path = $board->paths()->where('path_slug', $request->path_slug)->first();

        $path->delete();

        if($request->ajax()) {
            return response("", 200);
        }

        return redirect()->back();
    }

}
