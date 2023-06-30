<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getMovieList()
    {
        $movieApiUrl = "https://seleksi-sea-2023.vercel.app/api/movies";
        $movieApiResponse = Http::get($movieApiUrl);

        $movieApiResponseBody = json_decode($movieApiResponse->getBody());

        return collect($movieApiResponseBody)->shuffle();
    }
}
