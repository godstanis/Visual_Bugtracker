<?php

namespace App\Repositories;

use App\Issue;

class IssueRepository
{
    public function create($data)
    {
        $newIssue = Issue::create($data);

        $newIssue->save();

        return $newIssue;
    }

    public function delete(Issue $issue)
    {
        $issue->delete();
    }

    public function update()
    {
        //... TODO
    }
}