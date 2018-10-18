<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Services\User\AbstractUserActivationService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendActivationEmail //implements ShouldQueue
{
    /**
     * @var AbstractUserActivationService
     */
    private $userActivationService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(AbstractUserActivationService $userActivationService)
    {
        $this->userActivationService = $userActivationService;
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

        $userActivationToken = app()->makeWith(AbstractUserActivationService::class, ['user'=>$user])->createToken();

        \Mail::to($user)->send(new \App\Mail\UserRegistered($user, $userActivationToken));
    }
}
