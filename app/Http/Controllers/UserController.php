<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class UserController extends Controller
{
    public function getUserProfilePage()
    {
        $user = auth()->user();
        $userBirthday = date('d F Y', strtotime($user->birthday));

        // get latest top up balance history
        $userLatestTopUpBalanceHistory = (new UserBalanceController)->getLatestTopUpBalanceHistory($user->id);
        $userLatestTicketTransactionHistory = (new TicketController)->getLatestTicketTransaction($user->id);

        return view('users.user-profile', [
            'user' => $user,
            'userBirthDay' => $userBirthday,
            'topUpBalanceHistory' => $userLatestTopUpBalanceHistory,
            'ticketTransactionHistory' => $userLatestTicketTransactionHistory,
        ]);
    }
}
