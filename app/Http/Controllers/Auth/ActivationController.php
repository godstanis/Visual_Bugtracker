<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\UserActivation;
use App\Repositories\UserRepository;
use App\Repositories\UserActivationRepository;

class ActivationController extends Controller
{

    protected $user_repository;
    protected $user_activation_repository;

    public function __construct(UserRepository $user_repository, UserActivationRepository $user_activation_repository)
    {
        $this->user_repository = $user_repository;
        $this->user_activation_repository = $user_activation_repository;
    }

    public function activate($token)
    {

        $activated = $this->user_activation_repository->activateUserByToken($token);

        if($activated)
        {
            return view('auth.activation.success');
        }

        return view('auth.activation.failed');
    }
}
