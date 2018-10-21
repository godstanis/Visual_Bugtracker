<?php

namespace App\Observers;

Use App\Issue;

class IssueObserver
{
    /**
     * Listen to the Issue creating event and apply issue creator.
     *
     * @param  Issue  $issue
     * @return void
     */
    public function creating(Issue $issue)
    {
        if(!isset($issue->created_by_user_id)) {
            $issue->created_by_user_id = auth()->user()->id;
        }
    }

    /**
     * Listen to the Issue deleted event.
     *
     * @param  Issue  $issue
     * @return void
     */
    public function deleted(Issue $issue)
    {
        $issue->discussion()->delete();
    }
}