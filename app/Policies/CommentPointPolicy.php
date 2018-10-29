<?php

namespace App\Policies;

use App\User;
use App\CommentPoint;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPointPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the comment point.
     *
     * @param  \App\User  $user
     * @param  \App\CommentPoint  $commentPoint
     * @return mixed
     */
    public function view(User $user, CommentPoint $commentPoint)
    {
        return true;
    }

    /**
     * Determine whether the user can create comment points.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the comment point.
     *
     * @param  \App\User  $user
     * @param  \App\CommentPoint  $commentPoint
     * @return mixed
     */
    public function update(User $user, CommentPoint $commentPoint)
    {
        return $this->delete($user, $commentPoint);
    }

    /**
     * Determine whether the user can delete the comment point.
     *
     * @param  \App\User  $user
     * @param  \App\CommentPoint  $commentPoint
     * @return mixed
     */
    public function delete(User $user, CommentPoint $commentPoint)
    {
        return $commentPoint->creator->id === $user->id;
    }

    /**
     * Determine whether the user can restore the comment point.
     *
     * @param  \App\User  $user
     * @param  \App\CommentPoint  $commentPoint
     * @return mixed
     */
    public function restore(User $user, CommentPoint $commentPoint)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the comment point.
     *
     * @param  \App\User  $user
     * @param  \App\CommentPoint  $commentPoint
     * @return mixed
     */
    public function forceDelete(User $user, CommentPoint $commentPoint)
    {
        //
    }
}
