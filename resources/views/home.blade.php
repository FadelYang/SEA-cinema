@extends('layouts.app')

@section('content')
    {{-- search input --}}
    <section class="container input-group mt-5">
        <input type="text" class="form-control" placeholder="Search movie name" aria-label="Movie Name"
            aria-describedby="basic-addon2">
        <span class="input-group-text" id="basic-addon2"><i class="fas fa-search"></i></span>
    </section>


    {{-- movie list section --}}
    <section class="container mt-3">
        @include('movies.movie-list')
    </section>

    {{-- pagination --}}
    <section class="container mt-2">
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item">
                    <a href="{{ $movies->previousPageUrl() }}" class="page-link">
                        Previous
                    </a>
                </li>
                @for ($i = 1; $i <= $movies->lastPage() + 1; $i++)
                    <li class="page-item {{ $movies->currentPage() == $i ? 'active' : '' }}">
                        <a href="{{ $movies->url($i) }}" class="page-link">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item">
                    <a href="{{ $movies->nextPageUrl() }}" class="page-link">
                        Next
                    </a>
                </li>
            </ul>
        </nav>
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
