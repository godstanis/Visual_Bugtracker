<?php

namespace App\Observers;

use App\IssueDiscussion;

class IssueDiscussionObserver
{
    /**
     * Listen to the IssueDiscussion creating event and apply issue creator.
     *
     * @param  IssueDiscussion  $issueDiscussion
     * @return void
     */
    public function creating(IssueDiscussion $issueDiscussion)
    {
        $issueDiscussion->user_id = auth()->user()->id;
    }

    /**
     * Listen to the IssueDiscussion deleting event.
     *
     * @param  IssueDiscussion  $issueDiscussion
     * @return void
     */
    public function deleting(IssueDiscussion $issueDiscussion)
    {
        //
    }
}