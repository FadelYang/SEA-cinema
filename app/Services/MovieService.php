<?php

namespace App\Services;

use App\Repositories\EloquentMovieRepository;

class MovieService
{
    public $eloquentMovieRepository;

    public function __construct(EloquentMovieRepository $eloquentMovieRepository)
    {
        $this->eloquentMovieRepository = $eloquentMovieRepository;
    }

    public function getmovieDetailPage($movieTitle)
    {
        $movieItem = $this->eloquentMovieRepository->getMovieDetail($movieTitle);
        $movies = $this->eloquentMovieRepository->getMovieList(
            inRandomOrder: true,
            isPaginate: false,
            excludeTitle: $movieTitle
        );

        return view('movies.movie-detail', [
            'movieDetail' => $movieItem,
            'movies' => $movies,
        ]);

    }
}