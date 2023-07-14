<?php

namespace App\Services;

use App\Repositories\EloquentTopUpBalanceRepository;

class topUpBalanceService
{
    private $eloquentTopUpBalanceRepository;

    public function __construct(EloquentTopUpBalanceRepository $eloquentTopUpBalanceRepository)
    {
        $this->eloquentTopUpBalanceRepository = $eloquentTopUpBalanceRepository;
    }

    public function topUpBalance($user, $updateBalance, $topUpAmount)
    {
        $this->eloquentTopUpBalanceRepository->topUpBalance($user, $updateBalance);

        $this->eloquentTopUpBalanceRepository->storeTopUpBalanceHistory($user, $topUpAmount, $topUpNotes = "Top up balance");
    }

    public function getTopUpBalanceHistory($userId)
    {
        return $this->eloquentTopUpBalanceRepository->getTopUpBalanceHistory($userId);
    }
}

