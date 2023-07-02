<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function getUserProfilePage()
    {
        $user = auth()->user();
        // dd($user->username);

        return view('users.user-profile', ['user' => $user]);
    }
}
