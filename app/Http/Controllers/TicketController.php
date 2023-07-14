<?php

namespace App\Http\Controllers;

use App\Enum\TicketStatusEnum;
use App\Models\TicketTransactionModel;
use App\Models\User;
use App\Services\ticketTransactionService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TicketController extends Controller
{
    private $ticketTransactionService;
    private $userService;

    public function __construct(
        ticketTransactionService $ticketTransactionService,
        UserService $userService
    ) {
        $this->ticketTransactionService = $ticketTransactionService;
        $this->userService = $userService;
    }

    public function getBuyTicketPage($movieTitle)
    {
        $buyTicketData =  $this->ticketTransactionService->getBuyTicketPage($movieTitle);

        $isUserAgeUnderMovieRating = $this->ticketTransactionService->isUserAgeUnderMovieRating(
            $buyTicketData['movieItem'],
            $buyTicketData['userAge']
        );

        if ($isUserAgeUnderMovieRating) {
            return Redirect::back()->with('message', 'Umur anda tidak mencukupi untuk film yang anda pilih');
        }

        return view('tickets.buy-ticket', [
            'movie' => $buyTicketData['movieItem'],
            'bookedSeats' => $buyTicketData['bookedSeats'],
        ])->with('totalTicketMessage', "You already have " . $buyTicketData['userBookedSeats'] . " tickets for this movie, the maximum is 6");
    }

    public function buyTicket(Request $request)
    {
        try {
            $request->validate([
                'movie_title' => ['string', 'required'],
                'movie_age_rating' => ['required'],
                'seat_number' => ['string', 'max: 10'],
                'status' => ['in:SUCCESS, FAILED'],
            ]);

            $buyTicket = $this->ticketTransactionService->buyTicket($request);

            if ($buyTicket['selectedSeats'] === null) {
                return Redirect::back()->with('message', 'Silahkan pilih tempat duduk terlebih dahulu');
            }

            if ($buyTicket['totalUserTicketPerFilm'] > 6) {
                return Redirect::back()->with('message', "Anda sudah mencapai batas jumlah tiket yang dapat dibeli");
            }

            if ($buyTicket['userBalance'] < $buyTicket['totalTicketPrice']) {
                return Redirect::back()->with(
                    'message',
                    "Total balance anda tidak mencukupi untuk membeli tiket (total harga tiket: " . $buyTicket['totalTicketPrice'] . " , balance anda: " .  $buyTicket['user']->balance . ")"
                );
            }

            $this->ticketTransactionService->storeBuyTicketData(
                selectedSeats: $buyTicket['selectedSeats'],
                request: $request,
                totalPrice: $buyTicket['totalTicketPrice']
            );

            return Redirect::back()->with('success', "Berhasil membeli tiket");
        } catch (\Throwable $th) {
            return Redirect::back()->with('message', "Ada kesalahan, pastika anda sudah memilih tempat duduk dengan benar");
        }
    }

    public function getTicketDetail($user, $ticketXId)
    {
        $ticketDetail = $this->ticketTransactionService->getTicketDetail($ticketXId);

        return view(
            'tickets.detail-ticket',
            [
                'user' => $ticketDetail['user'],
                'ticketItem' => $ticketDetail['ticketItem']
            ]
        );
    }

    public function getIndexTicketTransactionHistoryPage()
    {
        $user = $this->userService->getLoginUser();
        $userTicketTransactionHistory = $this->ticketTransactionService->getAllTicketTransaction($user->id);

        return view('tickets.index-history', [
            'ticketTransactionHistory' => $userTicketTransactionHistory['ticketData'],
        ]);
    }

    public function cancelBuyTicket($user, $ticketXId)
    {
        try {
            $user = $this->userService->getLoginUser();

            $ticketItem = $this->ticketTransactionService->getTicketDetail($ticketXId);

            if ($ticketItem['ticketItem']->status === TicketStatusEnum::CANCELED->value) {
                return Redirect()->back()->with('message', 'Tiket anda sudah dibatalkan');
            }

            $this->ticketTransactionService
                ->cancelBuyTicket(
                    user: $user,
                    ticketXId: $ticketItem['ticketItem']->xid,
                    ticketPrice: $ticketItem['ticketItem']->ticket_price
                );

            return Redirect()->back()->with('success', 'Berhasil membatalkan tiket, saldo anda sudah diupdate sesuai jumlah tiket yang direfund');
        } catch (\Throwable $th) {
            dd($th);
            return Redirect()->back()->with('message', 'Gagal membatalkan tiket, silahkan coba lagi');
        }
    }
}
