@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-8">
                <p class="h3 text-center">Seat Layout</p>

                <p class="text-center m-5">SCREEN</p>

                <div class="overflow-scroll seat-layout-wrap">
                    <div class="btn-group mt-5" role="group" aria-label="Basic checkbox toggle button group">
                        @for ($row = 1; $row <= 9; $row++)
                            <div class="row">
                                @for ($col = 1; $col <= 7; $col++)
                                    <div class="col my-1 mx-sm-0 mx-1">
                                        <input type="checkbox" class="btn-check small-checkbox"
                                            id="btncheck{{ $row }}{{ $col }}" autocomplete="off">
                                        <label class="btn btn-outline-primary"
                                            for="btncheck{{ $row }}{{ $col }}">
                                            {{ chr(64 + $col) }}{{ $row }}
                                        </label>
                                    </div>
                                @endfor
                            </div>
                        @endfor
                    </div>
                </div>


            </div>

            <div class="col-sm-4 mt-sm-0 mt-5">
                <div class="row">
                    <div class="col-12">
                        <p class="h3 text-center mb-5">Film Detail</p>

                        @foreach ($movie as $movie)
                            {{-- detail movie section --}}
                            <p class="h5">Title : <span
                                    class="badge bg-primary">{{ $movie->title }}</span>
                            </p>
                            <p class="h5">Release Date : <span
                                    class="badge bg-primary">{{ Carbon\Carbon::createFromFormat('Y-m-d', $movie->release_date)->format('d F Y') }}</span>
                            </p>
                            <p class="h5">Ticket Price : <span
                                    class="badge bg-primary">{{ $movie->ticket_price }}</span></p>
                            <p class="h5">Age Rating : <span class="badge bg-primary">{{ $movie->age_rating }}</span>
                        @endforeach
                    </div>
                    <div class="col-12 mt-5">
                        <p class="h3 text-center">Ticket Detail</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
@endsection

@push('css')
    <style>
        /* hide scrollbar for aesthetically purpose */
        .seat-layout-wrap {
            -ms-overflow-style: none;
            /* Internet Explorer 10+ */
            scrollbar-width: none;
            /* Firefox */
        }

        .seat-layout-wrap::-webkit-scrollbar {
            display: none;
            /* Safari and Chrome */
        }
    </style>
@endpush
