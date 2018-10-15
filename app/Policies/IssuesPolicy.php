<?php

namespace App\Policies;

use App\User;
use App\Issue;
use App\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssuesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the issue.
     *
     * @param  \App\User  $user
     * @param  \App\Issue  $issue
     * @return mixed
     */
    public function view(User $user, Issue $issue)
    {
        return true;
    }

    /**
     * Determine whether the user can create issues.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Issue $issue)
    {
        return true;
    }

    /**
     * Determine whether the user can update the issue.
     *
     * @param  \App\User  $user
     * @param  \App\Issue  $issue
     * @return mixed
     */
    public function update(User $user, Issue $issue)
    {
        
        return $this->delete($user, $issue);
    }

    /**
     * Determine whether the user can delete the issue.
     *
     * @param  \App\User  $user
     * @param  \App\Issue  $issue
     * @return mixed
     */
    public function delete(User $user, Issue $issue)
    {

        $project = $issue->project;

        $issueCreatedByUser = $issue->created_by_user_id === $user->id;
        $projectCreatedByUser = $project->creator_user_id === $user->id;

        return ( $issueCreatedByUser || $projectCreatedByUser);
    }
}
