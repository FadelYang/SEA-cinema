<?php

namespace App\Http\Controllers;

use App\Enum\TicketStatusEnum;
use App\Models\TicketTransactionModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Symfony\Component\Console\Input\Input;
use Hidehalo\Nanoid\Client;
use Hidehalo\Nanoid\GeneratorInterface;

class TicketController extends Controller
{
    public function getBuyTicketPage($movieTitle)
    {
        $user = auth()->user();
        $movieItem = collect((new MovieController)->getMovieData())->where('title', $movieTitle);
        $userAge = Carbon::parse($user->birthday)->age;
        $bookedSeats = TicketTransactionModel::where([
            ['status', TicketStatusEnum::SUCCESS],
            ['movie_title', $movieTitle]
        ])->get();

        $userBookedSeats = count(TicketTransactionModel::where([
            ['user_id', $user->id],
            ['movie_title', $movieTitle],
            ['status', TicketStatusEnum::SUCCESS->value],
        ])->get());

        // check are user can watch the movie depend their age
        foreach ($movieItem as $movie) {
            $movieAgeRating = $movie->age_rating;
        }

        if ($userAge <= $movieAgeRating) {
            return Redirect::back()->with('message', 'Umur anda tidak mencukupi untuk film yang anda pilih');
        }

        return view('tickets.buy-ticket', [
            'movie' => $movieItem,
            'bookedSeats' => $bookedSeats,
        ])->with('totalTicketMessage', "You already have $userBookedSeats tickets for this movie, the maximum is 6");
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

            $selectedSeats = $request->input('seats'); // get all selected seats

            $userTicketPerFilm = TicketTransactionModel::where([
                ['status', TicketStatusEnum::SUCCESS],
                ['movie_title', $request->movie_title],
                ['user_id', auth()->user()->id]
            ])->get();

            if ((count($userTicketPerFilm) + count($selectedSeats)) > 6) {
                return Redirect::back()->with('message', "Anda sudah mencapai batas jumlah tiket yang dapat dibeli");
            }

            if ($selectedSeats === null) {
                return Redirect::back()->with('message', 'Silahkan pilih tempat duduk terlebih dahulu');
            }

            $totalPrice = $request->ticket_price * count($selectedSeats);
            $userBalance = auth()->user()->balance !== null ? auth()->user()->balance : '0';

            if (auth()->user()->balance < $totalPrice) {
                return Redirect::back()->with('message', "Total balance anda tidak mencukupi untuk membeli tiket (total harga tiket: $totalPrice, balance anda: $userBalance)");
            }

            $clientNanoId = new Client();

            foreach ($selectedSeats as $seatNumber) {
                TicketTransactionModel::create([
                    'user_id' => auth()->user()->id,
                    'xid' => $clientNanoId->generateId($size = 10),
                    'movie_title' => $request->movie_title,
                    'movie_age_rating' => $request->movie_age_rating,
                    'ticket_price' => $request->ticket_price,
                    'seat_number' => $seatNumber,
                    'status' => TicketStatusEnum::SUCCESS,
                ]);

                User::where('id', auth()->user()->id)
                    ->update(['balance' => (auth()->user()->balance - $totalPrice)]);
            }

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

    public function getLatestTicketTransaction($userId)
    {
        return TicketTransactionModel::where('user_id', $userId)->orderBy('created_at', 'desc')->first();
    }

    public function getAllTicketTransaction($userId)
    {
        return TicketTransactionModel::where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(9);
    }
}
