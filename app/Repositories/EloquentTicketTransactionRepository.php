<?php

namespace App\Repositories;

use App\Models\TicketTransactionModel;

class EloquentTicketTransactionRepository
{
    public function getLatestTicketTransaction($userId)
    {
        return TicketTransactionModel::where('user_id', $userId)->orderBy('created_at', 'desc')->first();
    }

    public function getAllTicketTransaction($userId)
    {
        return TicketTransactionModel::where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(9);
    }
}