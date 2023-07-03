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
        $movieItem = collect((new MovieController)->getMovieData())->where('title', $movieTitle);
        $userAge = Carbon::parse(auth()->user()->birthday)->age;
        $bookedSeats = TicketTransactionModel::where([
            ['status', TicketStatusEnum::SUCCESS],
            ['movie_title', $movieTitle]
        ])->get();

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
        ]);
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
                    'seat_number' => $seatNumber,
                    'status' => TicketStatusEnum::SUCCESS,
                ]);

                User::where('id', auth()->user()->id)
                    ->update(['balance' => (auth()->user()->balance - $totalPrice)]);
            }

            return Redirect::back()->with('success', "Berhasil membeli tiket");
        } catch (\Throwable $th) {
            return Redirect::back()->with('message', "Ada kesalahan, pastika anda sudah memilih tempat duduk dengan benar $th");
        }
    }
}
