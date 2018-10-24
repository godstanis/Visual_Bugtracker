<?php

namespace App\Policies;

use App\User;
use App\Board;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the board.
     *
     * @param  \App\User  $user
     * @param  \App\Board  $board
     * @return bool
     */
    public function view(User $user, Board $board): bool
    {
        return $user->can('view', $board->project);
    }

    /**
     * Determine whether the user can create boards.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the board.
     *
     * @param  \App\User  $user
     * @param  \App\Board  $board
     * @return bool
     */
    public function update(User $user, Board $board): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the board.
     *
     * @param  \App\User  $user
     * @param  \App\Board  $board
     * @return bool
     */
    public function delete(User $user, Board $board): bool
    {
        $isProjectCreator = $board->project->creator->id === $user->id;
        $isBoardCreator = $user->id === $board->creator->id;

        return $isBoardCreator || $isProjectCreator;
    }
}
