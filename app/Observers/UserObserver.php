<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    /**
     * Handle the user "creating" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        if(!isset($user->profile_image)) {
            $user->profile_image = config('images.default_user_avatar');
        }
    }
}
