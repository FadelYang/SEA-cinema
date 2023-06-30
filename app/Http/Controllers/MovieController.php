<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function getMovieData()
    {
        $movieApiUrl = "https://seleksi-sea-2023.vercel.app/api/movies";
        $movieApiResponse = Http::get($movieApiUrl);

        return json_decode($movieApiResponse->getBody());
    }

    public function getMovieList($inRandomOrder)
    {
        $movieApiResponseBody = $this->getMovieData();

        if (!$inRandomOrder) {
            $movieApiResponseBody = $this->getMovieData();

            return collect($movieApiResponseBody)->paginate(10);
        }
        
        $movieCollection = collect($movieApiResponseBody)->shuffle();
        
        return $movieCollection->paginate(10);
    }
}