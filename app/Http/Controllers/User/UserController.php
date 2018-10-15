<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UserUpdateImageForm;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
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
        $user_repository = app()->makeWith(UserRepository::class, ['user'=>auth()->user()]);
        $user_repository->updateUserImage( $request->file('profile_image') );

        return redirect()->back();
    }
}
