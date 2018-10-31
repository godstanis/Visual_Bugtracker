<?php

namespace App\Services\User;

class UserActivationService extends AbstractUserActivationService
{
    protected $user;
    protected $userActivation;

    /**
     * Creates a UserActivation instance for a User ($this->user).
     *
     * @return string
     */
    public function createToken(): string
    {
        $this->userActivation->user_id = $this->user->id;
        $this->userActivation->token = str_random(32).uniqid('',false);

        $this->userActivation->save();
        return $this->userActivation->token;
    }

    /**
     * Activates User account by a valid token.
     *
     * @param string $token
     * @return bool
     */
    public function activateUserByToken(string $token): bool
    {
        $userActivation = $this->userActivation->where('token', $token)->first();
        if($userActivation === null) {
            return false;
        }

        return $userActivation->user->activateAccount();
    }
}
