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
        $data = [
            'userName' => $user->name,
            'userEmail' => $user->email,
            'profileImagePath' => $user->imageLink(),
        ];

        return view('user.one', $data);

    }

    public function getUserSettings()
    {
        $data = [
            'userName' => auth()->user()->name,
            'userEmail' => auth()->user()->email,
            'profileImagePath' => auth()->user()->imageLink(),
        ];
        
        return view('user.settings', $data);

    }

    public function postUserProfileImage(UserUpdateImageForm $request)
    {
        $user_repository = app()->makeWith(UserRepository::class, ['user'=>auth()->user()]);
        $user_repository->updateUserImage( $request->file('profile_image') );

        return redirect()->back();
        
    }
}
