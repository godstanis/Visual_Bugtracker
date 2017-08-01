<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Repositories\UserActivationRepository;

class SendActivationEmail //implements ShouldQueue
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
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->user;

        $user_activation_repository = new UserActivationRepository();
        $user_activation_token = $user_activation_repository->generateToken($user);

        \Mail::to($user)->send(new \App\Mail\UserRegistered($user, $user_activation_token));
    }
}
