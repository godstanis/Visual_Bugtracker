<?php

namespace App\Http\Controllers\Bugtracker;

use App\Board;
use App\CommentPoint;
use App\Http\Resources\CommentPoint\CommentPointCollection;
use App\Http\Resources\CommentPoint\CommentPointResource;
use App\Project;

use Illuminate\Http\Request;

use App\Http\Controllers\BugtrackerBaseController;

class CommentPointController extends BugtrackerBaseController
{
    /**
     * Display a listing of the comment points for the board.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Project $project, Board $board)
    {
        $boardCommentPoints = new CommentPointCollection($board->commentPoints()->with('issue', 'issue.project', 'creator')->get());
        return response($boardCommentPoints, 200);
    }

    /**
     * Display the specified comment point of the board.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, Board $board, $id)
    {
        $commentPoints = new CommentPointResource($board->commentPoints()->find($id));
        return response($commentPoints, 200);
    }

    /**
     * Store a newly created comment point.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project, Board $board)
    {
        if(isset($request->issue_id) && !is_numeric($request->issue_id)) {
            $request->request->remove('issue_id');
        }
        $commentPoint = $board->commentPoints()->create($request->all()+['user_id'=>auth()->user()->id]);
        $commentPoint->load('creator');
        return response($commentPoint, 200);
    }

    /**
     * Update the specified comment point.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project, Board $board, CommentPoint $commentPoint)
    {
        $commentPoint->update($request->all());
        return response("", 200);
    }

    /**
     * Remove the specified comment point from the board.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Project $project, Board $board, CommentPoint $commentPoint)
    {
        $commentPoint->delete();
        return response("", 200);
    }
}
