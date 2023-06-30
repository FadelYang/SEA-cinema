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
        $movies = $this->getMovieList(inRandomOrder: false);
        $query = $request->get('query');

        if (sizeOf($request->all()) > 0 && $query !== null) {
            $movies = $movies->filter(function ($movie) use ($query) {
                return stripos($movie->title, $query) !== false;
            })->paginate(10);
        }

        return view('home', [
            'movies' => $movies,
            'showPagination' => is_null(request('all'))
        ]);

    }
}