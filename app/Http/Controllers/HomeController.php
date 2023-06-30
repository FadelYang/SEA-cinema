<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $movies = $this->getMovieList();

        dd($movies);

        return view('home', [$movies]);
    }

    private function getMovieList()
    {
        $apiUrl = "https://seleksi-sea-2023.vercel.app/api/movies";
        $response = Http::get($apiUrl);

        $movies = json_decode($response->getBody());

        return $movies;
    }
}
