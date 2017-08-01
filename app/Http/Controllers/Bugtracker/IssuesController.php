<?php

namespace App\Http\Controllers\Bugtracker;

use Illuminate\Http\Request;
use App\Http\Controllers\BugtrackerBaseController;

use App\User;
use App\Project;
use App\Issue;

use App\Repositories\IssueRepository;

class IssuesController extends BugtrackerBaseController
{

    public $issue_repository;

    public function __construct(IssueRepository $repository)
    {
        $this->issue_repository = $repository;
    }

    /*
     * Show all issues, assigned to current project
    */
    public function getProjectIssues(Request $request, Project $project)
    {
        //dd($request->closed_visible);
        $show_closed = $request->closed_visible ? true : false;

        if($show_closed === true)
        {
            $issues = $project->issues()->paginate(10);
        }
        else
        {
            $issues = $project->issues()->where('closed', $show_closed)->paginate(10);
        }

        if ($request->ajax()) {
            return view('bugtracker.project.partials.issues-block', compact('issues', 'project'));
        }

        return view('bugtracker.project.issues', compact('issues', 'project'));
    }

    /*
     * Create new issue, and store it
    */
    public function postCreateIssue(\App\Http\Requests\CreateIssueRequest $request, Project $project)
    {

        $assigned_to_user = \App\User::where('name', '=', $request->assigned_to_user_name)->first();

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'created_by_user_id' => auth()->user()->id,
            'project_id' => $project->id,
            'assigned_to_user_id' => $assigned_to_user->id,
            'type_id' => $request->type_id,
            'priority_id' => $request->priority_id,
        ];

        $this->issue_repository->create($data);

    }

    /*
     * Delete existing issue
    */
    public function postDeleteIssue(Project $project, Issue $issue)
    {

        $issue_repository = new IssueRepository;

        $issue_repository->delete($issue);

        $response = ['status' => true];
        
        return json_encode( $response );
    }

    public function closeIssue(Project $project, Issue $issue)
    {
        $issue->closed = true;
        $issue->update();

        session()->flash('message', 'Issue closed!');

        return redirect()->back();
    }

    public function openIssue(Project $project, Issue $issue)
    {
        $issue->closed = false;
        $issue->update();

        session()->flash('message', 'Issue re-opened!');

        return redirect()->back();
    }

}
