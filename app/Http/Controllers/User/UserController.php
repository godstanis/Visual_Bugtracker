<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UserUpdateImageForm;
use App\Services\User\AbstractUserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class UserController extends Controller
{

    public function getUserPage(User $user)
    {
        return view('user.one', compact('user'));
    }

    public function getUserSettings()
    {
        $user = auth()->user();
        
        return view('user.settings', compact('user'));
    }

    public function postUserProfileImage(UserUpdateImageForm $request)
    {
        $userService = app()->makeWith(AbstractUserService::class, ['user'=>auth()->user()]);
        $userService->updateUserImage( $request->file('profile_image') );

        return redirect()->back();
    }
}
