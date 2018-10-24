<?php

namespace App\Http\Controllers\Bugtracker;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Project;
use App\Board;

class PathController extends Controller
{

    public function all(Project $project, Board $board)
    {
        $board->paths->load('creator');
        return new \App\Http\Resources\Path\PathCollection($board->paths);
    }

    public function create(Request $request, Project $project, Board $board)
    {
        $path = $board->paths()->create($request->all());

        if($request->ajax()) {
            $response = [ 'path_slug' => $path->path_slug ];
            return response(json_encode($response), 200);
        }

        return redirect()->back();
    }

    public function destroy(Request $request, Project $project, Board $board)
    {
        $board->paths()->where('path_slug', $request->path_slug)->first()->delete();

        if($request->ajax()) {
            return response("", 200);
        }

        return redirect()->back();
    }

}
