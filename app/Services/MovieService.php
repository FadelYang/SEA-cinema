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
        
        return $movieItem;
    }

    public function getMovieList($inRandomOrder, $isPaginate, $excludeTitle)
    {
        return $this->eloquentMovieRepository
            ->getMovieList($inRandomOrder, $isPaginate, $excludeTitle);
    }
}