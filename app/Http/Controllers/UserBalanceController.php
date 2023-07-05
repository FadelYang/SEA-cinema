<?php

namespace App\Http\Controllers;

use App\Models\TopUpBalanceHistoryModel;
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

        // update balance user
        User::where('id', $user->id)->update(['balance' => $updateBalance]);

        // store top up balance history
        $this->storeTopUpBalanceHistory(userId: $user->id, topUpAmount: $request->balance);

        return Redirect()->back()->with('success', "Berhasil topup sebanyak $request->balance. Balance anda sekarang $updateBalance");
    }

    public function storeTopUpBalanceHistory($userId, $topUpAmount)
    {
        TopUpBalanceHistoryModel::create([
            'user_id' => $userId,
            'amount' => $topUpAmount,
            'notes' => "Top Up Balance",
        ]);
    }

    public function getIndexTopUpHistoryPage()
    {
        $user = auth()->user();
        $userTopUpBalanceHistory = $this->getTopUpBalanceHistory($user->id);

        return view('balances.index-history', [
            'topUpBalanceHistory' => $userTopUpBalanceHistory,
        ]);
    }

    public function getTopUpBalanceHistory($userId)
    {
        return TopUpBalanceHistoryModel::where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(9);
    }

    public function getLatestTopUpBalanceHistory($userId)
    {
        return TopUpBalanceHistoryModel::where('user_id', $userId)->orderBy('created_at', 'desc')->first();
    }
}
