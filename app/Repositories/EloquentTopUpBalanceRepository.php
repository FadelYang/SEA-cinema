<?php

namespace App\Repositories;

use App\Models\TopUpBalanceHistoryModel;

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

    public function storeTopUpBalanceHistory($userId, $topUpAmount, $topUpNotes)
    {
        TopUpBalanceHistoryModel::create([
            'user_id' => $userId,
            'amount' => $topUpAmount,
            'notes' => $topUpNotes,
        ]);
    }
}
