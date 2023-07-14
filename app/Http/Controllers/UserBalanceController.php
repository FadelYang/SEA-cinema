<?php

namespace App\Http\Controllers;

use App\Models\TopUpBalanceHistoryModel;
use App\Models\User;
use App\Services\topUpBalanceService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserBalanceController extends MovieController
{
    private $userService;
    private $topUpBalanceService;

    public function __construct(UserService $userService, topUpBalanceService $topUpBalanceService)
    {
        $this->userService = $userService;
        $this->topUpBalanceService = $topUpBalanceService;
    }

    public function getTopUpBalancePage()
    {
        $userData = $this->userService->getLoginUser();

        return view('balances.topup-page', ['user' => $userData]);
    }

    public function topUpBalance(Request $request)
    {
        try {
            $request->validate([
                'balance' => ['integer', 'required']
            ]);


            if ($request->balance < 10000) {
                return Redirect()->back()->with('message', 'minimum top up adalah 10.000');
            }

            $user = $this->userService->getLoginUser();
            $currentBalance = $user->balance;
            $updateBalance = $currentBalance + $request->balance;

            $this->topUpBalanceService->topUpBalance(
                user: $user,
                updateBalance: $updateBalance,
                topUpAmount: $request->balance
            );

            return Redirect()->back()->with('success', "Berhasil topup sebanyak $request->balance. Balance anda sekarang $updateBalance");
        } catch (\Throwable $th) {
            return Redirect()->back()->with('message', 'gagal melakukan topup, silahkan coba lagi');
        }
    }


    public function getIndexTopUpHistoryPage()
    {
        $user = $this->userService->getLoginUser();
        $userTopUpBalanceHistory = $this->topUpBalanceService->getTopUpBalanceHistory(userId: $user->id);

        return view('balances.index-history', [
            'topUpBalanceHistory' => $userTopUpBalanceHistory,
        ]);
    }
}
