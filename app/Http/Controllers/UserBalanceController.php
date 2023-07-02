<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserBalanceController extends MovieController
{
    public function getTopUpBalancePage()
    {
        $userData = auth()->user();

        return view('balances.topup-page', ['user' => $userData]);
    }

    public function topUpBalance(Request $request)
    {
        $request->validate([
            'balance' => ['integer', 'required']
        ]);

        if ($request->balance < 10000) {
            return Redirect()->back()->with('message', 'minimum top up adalah 10.000');
        }

        $user = auth()->user();
        $currentBalance = $user->balance;
        $updateBalance = $currentBalance + $request->balance;

        User::where('id', $user->id)->update(['balance' => $updateBalance]);

        return Redirect()->back()->with('success', "Berhasil topup sebanyak $currentBalance. Balance anda sekarang $updateBalance");
    }
}