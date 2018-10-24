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
     * @return bool
     */
    public function view(User $user, Issue $issue): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create issues.
     *
     * @param  \App\User $user
     * @param Issue $issue
     * @return bool
     */
    public function create(User $user, Issue $issue): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the issue.
     *
     * @param  \App\User  $user
     * @param  \App\Issue  $issue
     * @return bool
     */
    public function update(User $user, Issue $issue): bool
    {
        
        return $this->delete($user, $issue);
    }

    /**
     * Determine whether the user can delete the issue.
     *
     * @param  \App\User  $user
     * @param  \App\Issue  $issue
     * @return bool
     */
    public function delete(User $user, Issue $issue): bool
    {
        $project = $issue->project;

        $issueCreatedByUser = $issue->user_id === $user->id;
        $projectCreatedByUser = $project->user_id === $user->id;

        return ( $issueCreatedByUser || $projectCreatedByUser);
    }

    /**
     * Determine whether the user can close the issue.
     *
     * @param  \App\User  $user
     * @param  \App\Issue  $issue
     * @return bool
     */
    public function close(User $user, Issue $issue): bool
    {
        return ($issue->assignees->contains($user) || $this->delete($user, $issue));
    }

    /**
     * Determine whether the user can attach another user(or himself) to the issue.
     *
     * @param  \App\User  $user
     * @param  \App\Issue  $issue
     * @return bool
     */
    public function attach(User $user, Issue $issue, User $userToAttach): bool
    {
        return ($userToAttach->id === $user->id) || $this->delete($user, $issue);
    }
}
