<?php

namespace App\Policies;

use App\User;
use App\Path;
use Illuminate\Auth\Access\HandlesAuthorization;

class PathPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the path.
     *
     * @param User $user
     * @param Path $path
     * @return bool
     */
    public function delete(User $user, Path $path): bool
    {
        return $path->creator->id === $user->id;
    }
}
