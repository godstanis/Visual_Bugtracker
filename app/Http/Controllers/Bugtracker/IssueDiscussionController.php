<?php

namespace App\Http\Controllers\Bugtracker;

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

        return view('bugtracker.project.issue.discussion', ['discussion'=>$discussion, 'issue'=>$issue, 'project'=>$project]);
    }

    public function createMessage(Request $request, Project $project, Issue $issue)
    {   
        $this->validate($request, [
            'message_text' => 'required|string|min:3|max:1000'
        ]);
        $discussion = IssueDiscussion::create([
            'issue_id' => $issue->id,
            'user_id' => auth()->user()->id,
            'text' => $request->message_text,
        ]);

        $discussion->save();

        return redirect()->back();
    }

}
