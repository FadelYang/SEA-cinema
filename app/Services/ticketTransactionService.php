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

    public function checkIsUserAgeUnderMovieRating($movieItem, $userAge)
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

        if (($userTicketPerFilm + count($selectedSeats)) > 6) {
            return Redirect::back()->with('message', "Anda sudah mencapai batas jumlah tiket yang dapat dibeli");
        }

        if ($selectedSeats === null) {
            return Redirect::back()->with('message', 'Silahkan pilih tempat duduk terlebih dahulu');
        }

        $totalPrice = $request->ticket_price * count($selectedSeats);
        $userBalance = $user->balance !== null ? $user->balance : '0';

        if ($userBalance < $totalPrice) {
            return Redirect::back()->with('message', "Total balance anda tidak mencukupi untuk membeli tiket (total harga tiket: $totalPrice, balance anda: $userBalance)");
        }

        foreach ($selectedSeats as $seatNumber) {
            $this->eloquentTicketTransactionRepository
                ->storeBuyTicketData($request, $seatNumber);

            // update user balance after success buying ticket
            $this->eloquentUserRepository->updateBalanceUserAfterBuyTicket($totalPrice);
        }
    }
}
