<?php

namespace App\Policies;

use App\User;
use App\Project;
use App\ProjectAccess;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    private $projectAccess;

    public function __construct(ProjectAccess $projectAccess)
    {
        $this->projectAccess = $projectAccess;
    }

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @return bool
     */
    public function view(User $user, Project $project): bool
    {
        return $project->members->contains($user);
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @return bool
     */
    public function update(User $user, Project $project): bool
    {
        return $this->creator($user, $project);
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @return bool
     */
    public function delete(User $user, Project $project): bool
    {
        return $this->creator($user, $project);
    }

    /**
     * Is user created the project.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function creator(User $user, Project $project): bool
    {
        return $project->creator->id === $user->id;
    }
}
