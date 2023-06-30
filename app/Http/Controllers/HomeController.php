<?php

namespace App\Http\Controllers;

use App\Utils\PaginateCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $movies = $this->getMovieList();

        $query = $request->get('query');


        return view('home', [
            'movies' => $movies,
            'showPagination' => is_null(request('all'))
        ]);
    }

    public function getMovieList()
    {
        $movieApiUrl = "https://seleksi-sea-2023.vercel.app/api/movies";
        $movieApiResponse = Http::get($movieApiUrl);

        $movieApiResponseBody = json_decode($movieApiResponse->getBody());

        return collect($movieApiResponseBody)->paginate(2);
    }
}
