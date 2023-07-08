<?php

namespace App\Services;

use App\Repositories\EloquentMovieRepository;
use App\Repositories\EloquentTicketTransactionRepository;
use App\Repositories\EloquentUserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class ticketTransactionService
{
    private $eloquentTicketTransactionRepository;
    private $eloquentUserRepository;
    private $eloquentMovieRepository;

    public function __construct(
        EloquentTicketTransactionRepository $eloquentTicketTransactionRepository,
        EloquentUserRepository $eloquentUserRepository,
        EloquentMovieRepository $eloquentMovieRepository
    ) {
        $this->eloquentTicketTransactionRepository = $eloquentTicketTransactionRepository;
        $this->eloquentUserRepository = $eloquentUserRepository;
        $this->eloquentMovieRepository = $eloquentMovieRepository;
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
            "totalTicketPrice" => $totalPrice
            
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
}
