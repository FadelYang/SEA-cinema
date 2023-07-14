<?php

namespace App\Repositories;

use App\Models\TopUpBalanceHistoryModel;
use App\Models\User;

class EloquentTopUpBalanceRepository
{
   public function getTopUpBalanceHistory($userId)
    {
        return TopUpBalanceHistoryModel::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(9);
    }

    public function getLatestTopUpBalanceHistory($userId)
    {
        return TopUpBalanceHistoryModel::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function topUpBalance($user, $updateBalance)
    {
        // update balance value after topup
        User::where('id', $user->id)->update(['balance' => $updateBalance]);
    }

    public function storeTopUpBalanceHistory($user, $topUpAmount, $topUpNotes)
    {
        TopUpBalanceHistoryModel::create([
            'user_id' => $user->id,
            'amount' => $topUpAmount,
            'notes' => $topUpNotes,
        ]);
    }
}
