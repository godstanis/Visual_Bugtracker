<?php

namespace App\Services\User;

use App\User;
use App\UserActivation;

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

        if($this->userActivation->save()) {
            return $this->userActivation->token;
        }
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

        if($userActivation == null) {
            return false;
        }

        return $userActivation->user->activateAccount();
    }

    /**
     * Returns true or found UserActivation instance.
     *
     * @param $token
     * @return bool|UserActivation
     */
    public function findByToken(string $token)
    {
        $this->userActivation->where('token', $token)->first();

        if($this->userActivation == null) {
            return false;
        }

        return $this->userActivation;
    }
}
