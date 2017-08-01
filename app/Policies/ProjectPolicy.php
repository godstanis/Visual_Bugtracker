<?php

namespace App\Policies;

use App\User;
use App\Project;
use App\ProjectAccess;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @return mixed
     */
    public function view(User $user, Project $project)
    {

        $userIsCreator = ( $user->id === $project->creator_user_id );

        $project_access = ProjectAccess::where([
            ['user_id', $user->id],
            ['project_id', $project->id]
        ])->exists();
        

        if($userIsCreator || $project_access)
        {
            return true;
        }
        
        return false;


    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @return mixed
     */
    public function update(User $user, Project $project)
    {

        //return $user->id === $project->creator_user_id;
        if($this->creator($user, $project))
        {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @return mixed
     */
    public function delete(User $user, Project $project)
    {

        //return $user->id === $project->creator_user_id;
        if($this->creator($user, $project))
        {
            return true;
        }

        return false;
    }

    public function creator(User $user, Project $project)
    {
        return $user->id === $project->creator_user_id;
    }
}
