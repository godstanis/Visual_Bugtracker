<?php

namespace App\Policies;

use App\User;
use App\Path;
use Illuminate\Auth\Access\HandlesAuthorization;

class PathPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Path $path)
    {
        $isCreator = $user->id === $path->created_by_user_id;

        return $isCreator;
    }
}
