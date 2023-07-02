<?php

namespace App\Http\Controllers;


class UserBalanceController extends MovieController
{
    public function getTopUpBalancePage()
    {
        $userData = auth()->user();

        return view('balances.topup-page', ['user' => $userData]);
    }
}