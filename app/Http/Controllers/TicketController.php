<?php

namespace App\Http\Controllers;

use App\Enum\TicketStatusEnum;
use App\Models\TicketTransactionModel;
use App\Models\User;
use App\Services\ticketTransactionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Symfony\Component\Console\Input\Input;
use Hidehalo\Nanoid\Client;
use Hidehalo\Nanoid\GeneratorInterface;

class TicketController extends Controller
{
    private $ticketTransactionService;

    public function __construct(ticketTransactionService $ticketTransactionService)
    {
        $this->ticketTransactionService = $ticketTransactionService;
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
                return Redirect::back()->with('message', "Total balance anda tidak mencukupi untuk membeli tiket (total harga tiket: $totalPrice, balance anda: $userBalance)");
            }

            $this->ticketTransactionService->storeBuyTicketData(
                selectedSeats: $buyTicket['selectedSeats'],
                request: $request,
                totalPrice: $buyTicket['totalTicketPrice']
            );

            return Redirect::back()->with('success', "Berhasil membeli tiket");
        } catch (\Throwable $th) {
            dd($th);
            return Redirect::back()->with('message', "Ada kesalahan, pastika anda sudah memilih tempat duduk dengan benar");
        }
    }

    public function getTicketDetail($user = null, $ticketXId)
    {
        $user = auth()->user()->id;
        $ticketItem = TicketTransactionModel::where('xid', $ticketXId)->first();

        return view('tickets.detail-ticket', ['user' => $user, 'ticketItem' => $ticketItem]);
    }

    public function getIndexTicketTransactionHistoryPage()
    {
        $user = auth()->user();
        $userTicketTransactionHistory = $this->getAllTicketTransaction($user->id);

        return view('tickets.index-history', [
            'ticketTransactionHistory' => $userTicketTransactionHistory,
        ]);
    }

    public function cancelBuyTicket($user = null, $ticketXId)
    {
        try {
            $user = auth()->user();
            $ticketItem = TicketTransactionModel::where([
                ['user_id', $user->id],
                ['xid', $ticketXId],
            ])->first();

            if ($ticketItem->status === TicketStatusEnum::CANCELED->value) {
                return Redirect()->back()->with('message', 'Tiket anda sudah dibatalkan');
            }

            $ticketItem->update(['status' => TicketStatusEnum::CANCELED]);

            // update user balance when canceled process success and create new top up history
            (new UserBalanceController)
                ->storeTopUpBalanceHistory(
                    userId: $user->id,
                    topUpAmount: $ticketItem->ticket_price,
                    topUpNotes: "Ticket Refund"
                );

            // update balance user
            User::where('id', $user->id)->update(['balance' => $user->balance + $ticketItem->ticket_price]);

            return Redirect()->back()->with('success', 'Berhasil membatalkan tiket, saldo anda sudah diupdate sesuai jumlah tiket yang direfund');
        } catch (\Throwable $th) {
            return Redirect()->back()->with('error', 'Gagal membatalkan tiket, silahkan coba lagi');
        }
      

    }
}
