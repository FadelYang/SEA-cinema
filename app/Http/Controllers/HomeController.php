<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends MovieController
{
    /**
     * Show the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $movies = $this->getMovieList(false);

        $query = $request->get('query');


        return view('home', [
            'movies' => $movies,
            'showPagination' => is_null(request('all'))
        ]);
    }
}
