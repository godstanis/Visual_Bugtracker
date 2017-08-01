<?php

namespace App\Http\Controllers\Bugtracker;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Project;
use App\Board;
use App\Path;

class PathController extends Controller
{

    protected $path_repository;

    public function __construct(\App\Repositories\PathRepository $repository)
    {
        $this->path_repository = $repository;
    }

    public function savePath(Request $request, Project $project, Board $board)
    {

        $data = [
            'board_id' => $board->id,
            'created_by_user_id' => auth()->user()->id,
            'path_slug' => uniqid('path_'),
            'path_data' => $request->path_data,
            'stroke_color' => $request->stroke_color,
            'stroke_width' => $request->stroke_width,
        ];

        $this->path_repository->save($data);

        $response = [
            'path_slug' => $data['path_slug'],
        ];
        
        return json_encode($response);



    }

    public function deletePath(Request $request, Project $project, Board $board)
    {
        $this->path_repository->deleteBySlug($request->path_slug);
    }

}
