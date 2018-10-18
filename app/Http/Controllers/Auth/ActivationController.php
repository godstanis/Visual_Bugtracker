<?php

namespace App\Http\Controllers\Auth;

use App\Services\User\AbstractUserActivationService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivationController extends Controller
{
    protected $userActivationService;

    public function __construct(AbstractUserActivationService $userActivationService)
    {
        $this->userActivationService = $userActivationService;
    }

    /**
     * User activation by token.
     *
     * @param string $token A valid activation token.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activate(string $token)
    {
        $activated = $this->userActivationService->activateUserByToken($token);
        if($activated) {
            return view('auth.activation.success');
        }
        return view('auth.activation.failed');
    }
}
