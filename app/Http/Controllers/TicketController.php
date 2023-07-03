<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Console\Input\Input;

class TicketController extends Controller
{
    public function getBuyTicketPage($movieTitle)
    {
        $movieItem = collect((new MovieController)->getMovieData())->where('title', $movieTitle);
        $userAge = Carbon::parse(auth()->user()->birthday)->age;

        // check are user can watch the movie depend their age
        foreach ($movieItem as $movie) {
            $movieAgeRating = $movie->age_rating;
        }
        
        if ($userAge <= $movieAgeRating) {
            return Redirect::back()->with('message', 'Umur anda tidak mencukupi untuk film yang anda pilih');
        }

        return view('tickets.buy-ticket', [
            'movie' => $movieItem,
        ]);
    }

    public function buyTicket(Request $request)
    {
        $selectedSeats = $request->input('seats'); // get all selected seats

        $totalPrice = $request->ticket_price * count($selectedSeats);

        if (auth()->user()->balance < $totalPrice) {
            return Redirect::back()->with('message', "Total balance anda tidak mencukupi untuk membeli tiket (total harga tiket: $totalPrice, balance anda: " . auth()->user()->balance . ")");
        }


        if ($selectedSeats === null) {
            return Redirect::back()->with('message', 'Silahkan pilih tempat duduk terlebih dahulu');
        }

        foreach ($selectedSeats as $seatNumber) {
            
        }
        // dd($input['seats'], count($input['seats']));
    }
}