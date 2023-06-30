@extends('layouts.app')

@section('content')
    {{-- movie list section --}}
    <section class="container mt-5">
        <div class="row">
            @foreach ($movies as $movie)
                <div class="row col-6 mb-2">
                    <div class="col-6 imageContainer">
                        <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }} poster" class="img-fluid image">
                        <div class="detailButton">
                            <a class="btn btn-light mb-1" href="#">Lihat Detail</a>
                            <a class="btn btn-dark" href="#">Beli Tiket</a>
                        </div>
                    </div>
                    <div class="col-6 d-flex flex-column justify-content-between">
                        <div>
                            <p class="h3">{{ $movie->title }}</p>
                            <p class="movieDescription">{{ $movie->description }}</p>
                        </div>
                        <div>
                            <p>Release Date: <span
                                    class="badge bg-primary">{{ Carbon\Carbon::createFromFormat('Y-m-d', $movie->release_date)->format('d F Y') }}</span>
                            </p>
                            <p>Age Rating: <span class="badge bg-primary">{{ $movie->age_rating }}</span></p>
                            <p>Ticket Price: <span class="badge bg-primary">{{ $movie->ticket_price }}</span></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@push('css')
    <style>
        .movieDescription {
            overflow: scroll;
            display: -webkit-box;
            -webkit-line-clamp: 6;
            -webkit-box-orient: vertical;
        }

        .detailButton {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .image {
            opacity: 1;
            display: block;
            width: 100%;
            height: auto;
            transition: .5s ease;
            backface-visibility: hidden;
        }

        .imageContainer {
            position: relative
        }

        .imageContainer:hover .image {
            opacity: 0.3;
        }

        .imageContainer:hover .detailButton {
            opacity: 1;
        }
    </style>
@endpush
