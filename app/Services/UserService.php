<?php

namespace App\Services;

use App\Repositories\EloquentTicketTransactionRepository;
use App\Repositories\EloquentTopUpBalanceRepository;
use App\Repositories\EloquentUserRepository;

class UserService
{
    private $eloquentUserRepository;
    private $eloquentTicketTransactionRepository;
    private $eloquentTopUpBalanceRepository;

    public function __construct(
        EloquentUserRepository $eloquentUserRepository,
        EloquentTicketTransactionRepository $eloquentTicketTransactionRepository,
        EloquentTopUpBalanceRepository $eloquentTopUpBalanceRepository
    ) {
        $this->eloquentUserRepository = $eloquentUserRepository;     
        $this->eloquentTicketTransactionRepository = $eloquentTicketTransactionRepository;     
        $this->eloquentTopUpBalanceRepository = $eloquentTopUpBalanceRepository;     
    }

    public function getUserProfilePage()
    {
        $user = $this->eloquentUserRepository->getLoginUser();

        $userLatestTopUpBalanceHistory = $this->eloquentTopUpBalanceRepository
            ->getLatestTopUpBalanceHistory($user->id);

        $userLatestTicketTransactionHistory = $this->eloquentTicketTransactionRepository
            ->getLatestTicketTransaction($user->id);

        return view('users.user-profile', [
            'user' => $user,
            'userBirthDay' => date('d F Y', strtotime($user->birthday)),
            'topUpBalanceHistory' => $userLatestTopUpBalanceHistory,
            'ticketTransactionHistory' => $userLatestTicketTransactionHistory,
        ]);
    }
}