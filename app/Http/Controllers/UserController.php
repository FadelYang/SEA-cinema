<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class UserController extends Controller
{
    public function getUserProfilePage()
    {
        $user = auth()->user();
        $userBirthday = date('d F Y', strtotime($user->birthday));
        // dd($user->username);

        return view('users.user-profile', [
            'user' => $user,
            'userBirthDay' => $userBirthday,
        ]);
    }
}
