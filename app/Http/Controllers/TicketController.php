<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class TicketController extends Controller
{
    public function getBuyTicketPage($movieTitle)
    {
        $movieItem = collect((new MovieController)->getMovieData())->where('title', $movieTitle);

        return view('tickets.buy-ticket', ['movie' => $movieItem]);
    }
}