<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function getMovieData()
    {
        $movieApiUrl = "https://seleksi-sea-2023.vercel.app/api/movies";
        $movieApiResponse = Http::get($movieApiUrl);

        return json_decode($movieApiResponse->getBody());
    }

    public function getMovieList($inRandomOrder, $isPaginate)
    {
        $movieApiResponseBody = $this->getMovieData();
        $movieCollection = collect($movieApiResponseBody);

        if ($inRandomOrder) {
            $movieCollection = $movieCollection->shuffle();
        }

        if ($isPaginate) {
            $movieCollection = $movieCollection->paginate(10);
        }

        return $movieCollection;
    }

    public function getMovieDetail($movieTitle)
    {
        $movieDetail = collect($this->getMovieData())->where('title', $movieTitle);
        $movies = $this->getMovieList(inRandomOrder: true, isPaginate: false)->whereNotIn('title', $movieTitle);

        return view('movies.movie-detail', [
                'movieDetail' => $movieDetail,
                'movies' => $movies,
            ]);
    }
}
