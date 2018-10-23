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
        if(!isset($issue->user_id)) {
            $issue->user_id = auth()->user()->id;
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