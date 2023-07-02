<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

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
}