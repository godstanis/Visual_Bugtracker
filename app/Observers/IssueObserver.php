<?php

namespace App\Observers;

Use App\Issue;

class IssueObserver
{
    /**
     * Listen to the Issue created event and apply issue creator.
     *
     * @param  Issue  $issue
     * @return void
     */
    public function creating(Issue $issue)
    {
        $issue->created_by_user_id = auth()->user()->id;
    }

    /**
     * Listen to the Issue deleting event.
     *
     * @param  Issue  $issue
     * @return void
     */
    public function deleting(Issue $issue)
    {
        //
    }
}