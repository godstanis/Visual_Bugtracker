<?php

namespace App\Services\User;

use App\User;
use App\UserActivation;

abstract class AbstractUserActivationService
{
    protected $user;
    protected $userActivation;

    public function __construct(User $user, UserActivation $userActivation)
    {
        $this->user = $user;
        $this->userActivation = $userActivation;
    }

    /**
     * Creates a UserActivation instance for a User ($this->user).
     *
     * @return string
     */
    abstract public function createToken(): string;

    /**
     * Activates User account by a valid token.
     *
     * @param string $token
     * @return bool
     */
    abstract public function activateUserByToken(string $token): bool;

}
