<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends MovieController
{
    private $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index(Request $request)
    {
        $movies = $this->homeService->getHomePage($request);

        return view('home', [
            'movies' => $movies,
            'showPagination' => is_null(request('all'))
        ]);
    }
}