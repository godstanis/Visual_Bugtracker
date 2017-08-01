<?php

namespace App\Repositories;

use App\UserActivation;
use App\User;

class UserActivationRepository
{
    public function generateToken(User $user)
    {
        $user_activation = new UserActivation;

        $user_activation->user_id = $user->id;
        $user_activation->token = str_random(32);

        if( $user_activation->save() )
        {
            return $user_activation->token;
        }

        return false;
    }

    public function findByToken($token)
    {
        $user_activation = UserActivation::where('token', $token)->first();

        if($user_activation == null)
        {
            return false;
        }

        return $user_activation;
    }

    public function activateUserByToken($token)
    {
        $user_activation = UserActivation::where('token', $token)->first();

        if($user_activation == null)
        {
            return false;
        }

        return $this->activateUser($user_activation->user);
    }

    public function activateUser(User $user)
    {
        $user->activated = true;

        return $user->update();   
    }
}