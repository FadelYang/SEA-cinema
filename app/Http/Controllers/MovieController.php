<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    private $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function getMovieDetail($movieTitle)
    {
        return $this->movieService->getmovieDetailPage($movieTitle);
    }
}
