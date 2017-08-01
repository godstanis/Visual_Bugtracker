<?php

namespace App\Listeners;

use App\Events\UserAvatarChange;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteOldAvatar
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserAvatarChange  $event
     * @return void
     */
    public function handle(UserAvatarChange $event)
    {
        //
    }
}
