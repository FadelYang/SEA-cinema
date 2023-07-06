<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class MovieRepository
{
    public function getMovieData()
    {
        $movieApiUrl = "https://seleksi-sea-2023.vercel.app/api/movies";
        $movieApiResponse = Http::get($movieApiUrl);

        return json_decode($movieApiResponse->getBody());
    }
}