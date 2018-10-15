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
        return $path->creator->id === $user->id;
    }
}
