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
}
