<?php

namespace App\Http\Controllers\Bugtracker;

use App\Http\Requests\CreateIssueDiscussionRequest;
use App\Issue;
use App\Project;
use App\IssueDiscussion;
use Illuminate\Http\Request;
use App\Http\Controllers\BugtrackerBaseController;

class IssueDiscussionController extends BugtrackerBaseController
{
    public function getDiscussion(Project $project, Issue $issue)
    {
        $discussion = $issue->discussion;
        $discussion->load('creator');

        return view('bugtracker.project.issue.discussion', compact('discussion','issue', 'project'));
    }

    public function createMessage(CreateIssueDiscussionRequest $request, Project $project, Issue $issue)
    {
        $issue->discussion()->create($request->all());

        return redirect()->back();
    }

}
