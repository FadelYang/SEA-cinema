<?php

namespace App\Repositories;

class EloquentMovieRepository extends MovieRepository
{
    public function getMovieList($inRandomOrder = false, $isPaginate = false, $excludeTitle = null)
    {
        $movieCollection =  collect($this->getMovieData())->whereNotIn('title', $excludeTitle);

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
        return $this->getMovieList()->where('title', $movieTitle);
    }
}