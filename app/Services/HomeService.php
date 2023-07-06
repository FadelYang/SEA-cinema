<?php

namespace App\Services;

use App\Services\MovieService;

class HomeService extends MovieService
{
    public function getHomePage($request)
    {
        $movies = $this->eloquentMovieRepository
            ->getMovieList(inRandomOrder: false, isPaginate: true);
        $query = $request->get('query');

        if (sizeOf($request->all()) > 0 && $query !== null) {
            $movies = $movies->filter(function ($movie) use ($query) {
                return stripos($movie->title, $query) !== false;
            })->paginate(10);
        }

        return $movies;
    }
}