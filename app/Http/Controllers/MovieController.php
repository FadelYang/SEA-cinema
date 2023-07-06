<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class MovieController extends Controller
{
    private $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function getMovieDetail($movieTitle)
    {
        try {
            $movieItem = $this->movieService->getmovieDetailPage($movieTitle);

            $movies = $this->movieService->getMovieList(
                inRandomOrder: true,
                isPaginate: false,
                excludeTitle: $movieTitle
            );

            return view('movies.movie-detail', [
                'movieDetail' => $movieItem,
                'movies' => $movies,
            ]);
        } catch (\Throwable $th) {
            return Redirect()->back()->with('message', 'Film tidak ditemukan');
        }
    }
}
