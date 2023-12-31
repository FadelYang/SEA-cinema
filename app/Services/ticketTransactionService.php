<?php

namespace App\Services;

use App\Repositories\EloquentMovieRepository;
use App\Repositories\EloquentTicketTransactionRepository;
use App\Repositories\EloquentTopUpBalanceRepository;
use App\Repositories\EloquentUserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class ticketTransactionService
{
    private $eloquentTicketTransactionRepository;
    private $eloquentUserRepository;
    private $eloquentMovieRepository;
    private $eloquentTopUpBalanceRepository;

    public function __construct(
        EloquentTicketTransactionRepository $eloquentTicketTransactionRepository,
        EloquentUserRepository $eloquentUserRepository,
        EloquentMovieRepository $eloquentMovieRepository,
        EloquentTopUpBalanceRepository $eloquentTopUpBalanceRepository
    ) {
        $this->eloquentTicketTransactionRepository = $eloquentTicketTransactionRepository;
        $this->eloquentUserRepository = $eloquentUserRepository;
        $this->eloquentMovieRepository = $eloquentMovieRepository;
        $this->eloquentTopUpBalanceRepository = $eloquentTopUpBalanceRepository;
    }

    public function getBuyTicketPage($movieTitle)
    {
        $user = $this->eloquentUserRepository->getLoginUser();
        $userAge = Carbon::parse($user->birthday)->age;
        $movieItem = $this->eloquentMovieRepository->getMovieDetail($movieTitle);
        $bookedSeats = $this->eloquentTicketTransactionRepository
            ->getAllBookedSeats($movieTitle);

        $userBookedSeats = $this->eloquentTicketTransactionRepository
            ->getBookedSeatsByUser($movieTitle, $user->id);

        return [
            'movieItem' => $movieItem,
            'userAge' => $userAge,
            'bookedSeats' => $bookedSeats,
            'userBookedSeats' => $userBookedSeats,
        ];
    }

    public function isUserAgeUnderMovieRating($movieItem, $userAge)
    {
        foreach ($movieItem as $movie) {
            $movieAgeRating = $movie->age_rating;
        };

        if ($userAge <= $movieAgeRating) {
            return true;
        }

        return false;
    }

    public function buyTicket($request)
    {
        $user = $this->eloquentUserRepository->getLoginUser();

        $selectedSeats = $request->input('seats');

        $userTicketPerFilm = $this->eloquentTicketTransactionRepository
            ->getUserTotalTicketPerFilm($request->movie_title);

        if (!$this->areUserSelectedSeats($request)) {
            return [
                'selectedSeats' => $selectedSeats
            ];
        }

        $totalUserTicketPerFilm = $userTicketPerFilm + count($selectedSeats);

        $totalPrice = $request->ticket_price * count($selectedSeats);
        $userBalance = $user->balance !== null ? $user->balance : '0';

        return [
            "selectedSeats" => $selectedSeats,
            "totalUserTicketPerFilm" => $totalUserTicketPerFilm,
            "userBalance" => $userBalance,
            "totalTicketPrice" => $totalPrice,
            "user" => $user,
            
        ];
    }

    public function areUserSelectedSeats($request)
    {
        if ($request->input('seats') === null) {
            return false;
        }

        return true;
    }

    public function storeBuyTicketData($selectedSeats, $request, $totalPrice)
    {
        foreach ($selectedSeats as $seatNumber) {
            $this->eloquentTicketTransactionRepository
                ->storeBuyTicketData($request, $seatNumber);

            // update user balance after success buying ticket
            $this->eloquentUserRepository->updateBalanceUserAfterBuyTicket($totalPrice);
        }
    }

    public function getTicketDetail($ticketXId)
    {
        $user = $this->eloquentUserRepository->getLoginUser();
        $ticketItem = $this->eloquentTicketTransactionRepository
            ->getTicketDetail($ticketXId);

        return [
            'user' => $user,
            'ticketItem' => $ticketItem,
        ];
    }

    public function getAllTicketTransaction($user)
    {
        $ticketData = $this->eloquentTicketTransactionRepository->getAllTicketTransaction($user);

        return [
            'ticketData' => $ticketData
        ];
    }

    public function cancelBuyTicket($user, $ticketXId, $ticketPrice)
    {
        $this->eloquentTicketTransactionRepository
            ->cancelBuyTicket(ticketXId: $ticketXId);

        $this->eloquentUserRepository
            ->updateBalanceUserAfterCancelTicket(user: $user, refundPrice: $ticketPrice);
        
        $this->eloquentTopUpBalanceRepository->storeTopUpBalanceHistory(
            user: $user,
            topUpAmount: $ticketPrice,
            topUpNotes: "Refund Cancel Ticket"
        );
    }
}
