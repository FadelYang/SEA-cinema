<?php

namespace App\Repositories;

use App\Models\User;

class EloquentUserRepository
{
    public function getLoginUser()
    {
        return auth()->user();
    }

    public function updateBalanceUserAfterBuyTicket($totalPrice)
    {
        $user = $this->getLoginUser();

        User::where('id', $user->id)
            ->update(['balance' => ($user->balance - $totalPrice)]);
    }

    public function updateBalanceUserAfterCancelTicket($user, $refundPrice)
    {
        $user->update(['balance' => $user->balance + $refundPrice]);
    }
}