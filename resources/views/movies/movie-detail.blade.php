@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @foreach ($movieDetail as $movie)
            <p class="h1 text-center mb-2">{{ $movie->title }} ({{ $movie->age_rating }}+)</p>

            {{-- detail movie section --}}
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }} poster" class="img-fluid" title="{{ $movie->title }}">
                </div>
                <div class="col-md-8">
                    <a href="{{ route('ticket.buy-page', $movie->title) }}" class="btn btn-warning mt-md-0 mt-3 mb-3">Buy Ticket</a>
                    <p class="h5">Release Date : <span
                            class="badge bg-primary">{{ Carbon\Carbon::createFromFormat('Y-m-d', $movie->release_date)->format('d F Y') }}</span>
                    </p>
                    <p class="h5">Ticket Price : <span class="badge bg-primary">{{ $movie->ticket_price }}</span></p>
                    <p class="h5">Age Rating : <span class="badge bg-primary">{{ $movie->age_rating }}</span></p><br>
                    <p class="h5">Synopsis</p><br>
                    <p class="h5">{{ $movie->description }}</p>
                </div>
            </div>
        @endforeach

        {{-- now showing section --}}
        <p class="h1 text-center my-2">Now Showing</p>

        <div class="row">
            @foreach ($movies as $movie)
                <div class="col-sm-12 col-md-4 col-xl-2 mb-2">
                    <a href="{{ route('movie.detail', $movie->title) }}">
                        <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }} poster" class="img-fluid" title="{{ $movie->title }}">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
