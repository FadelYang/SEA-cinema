@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @include('components.alert-with-message')
    </div>
    @foreach ($movie as $movie)
        <form action="{{ route('ticket.buy', $movie->title) }}" method="POST" enctype="multipart/form-data" id="buyTicket">
            @csrf

            <div class="container mt-2">
                <div class="row">
                    <div class="col-xl-8">
                        <p class="h3 text-center bg-primary py-2 text-white">Seat Layout</p>


                        <div class="overflow-scroll seat-layout-wrap">
                            <p class="text-center m-5">SCREEN</p>
                            <div class="btn-group mt-1" role="group" aria-label="Basic checkbox toggle button group">
                                <div class="row">
                                    @for ($row = 1; $row <= 8; $row++)
                                        @for ($col = 1; $col <= 8; $col++)
                                            @php
                                                $seatNumber = ($row - 1) * 8 + $col;
                                                $disabled = false;
                                                foreach ($bookedSeats as $bookedSeat) {
                                                    if ($bookedSeat->seat_number == $seatNumber) {
                                                        $disabled = true;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            <div class="col-1 my-1 mx-sm-0 mx-2">
                                                <input type="checkbox" class="btn-check smallCheckbox seatCheckbox"
                                                    id="btncheck{{ $row }}{{ $col }}" autocomplete="off"
                                                    name="seats[]" value="{{ $seatNumber }}"
                                                    {{ $disabled ? 'disabled' : '' }}>
                                                <label class="btn {{ $disabled ? 'btn-secondary' : 'btn-primary' }}"
                                                    for="btncheck{{ $row }}{{ $col }}">
                                                    {{ $seatNumber }}
                                                </label>
                                            </div>
                                        @endfor
                                    @endfor
                                </div>


                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                <div class="mx-1 text-center">
                                    <input type="checkbox" class="btn-check smallCheckbox seatCheckbox" disabled>
                                    <label class="btn btn-secondary">
                                        ZZ
                                    </label>
                                    <p>booked</p>
                                </div>
                                <div class="mx-1 text-center">
                                    <input type="checkbox" class="btn-check smallCheckbox seatCheckbox">
                                    <label class="btn btn-primary">
                                        ZZ
                                    </label>
                                    <p>available</p>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="col-xl-4 mt-sm-0 mt-5">
                        <div class="row">
                            <div class="col-12">
                                <p class="h3 text-center mb-3 bg-primary py-2 text-white">Film Detail</p>


                                {{-- detail movie section --}}
                                <p class="h5">Title : <span class="badge bg-primary">{{ $movie->title }}</span>
                                </p>
                                <input type="text" name="movie_title" class="d-none" value="{{ $movie->title }}">
                                <p class="h5">Release Date : <span
                                        class="badge bg-primary">{{ Carbon\Carbon::createFromFormat('Y-m-d', $movie->release_date)->format('d F Y') }}</span>
                                </p>
                                <p class="h5">Ticket Price : <span
                                        class="badge bg-primary">{{ $movie->ticket_price }}</span></p>
                                <input type="text" name="ticket_price" class="d-none"
                                    value="{{ $movie->ticket_price }}">
                                <p class="h5">Age Rating : <span
                                        class="badge bg-primary">{{ $movie->age_rating }}</span>
                                    <input type="text" name="movie_age_rating" class="d-none"
                                        value="{{ $movie->age_rating }}">
    @endforeach
    </div>
    <div class="col-12 mt-2 ">
        <div>
            <p class="h3 text-center mb-3 bg-primary py-2 text-white">Ticket Detail</p>

            <p class="h5">Seat(s) Selected : <span id="selectedSeats" class="badge bg-primary"></span>
            </p>
            <p class="h5">Total Seat(s) : <span id="totalSeats" class="badge bg-primary totalSeats"></span>
                <span id="totalSeatsAlert" class="badge bg-danger"></span>
            </p>
            <p class="h5">Price Per Ticket : <span class="badge bg-primary"
                    id="ticketPrice">{{ $movie->ticket_price }}</span></p>
            <p class="h5">Ticket Total : <span class="badge bg-primary" id="totalTickets"></span>
            </p>
            <br>
            <p class="h5"><strong>Total Price : <span id="totalTicketPrice" class="badge bg-primary"></span></strong>
            </p>
        </div>
        <div>
            <a href="{{ route('movie.detail', $movie->title) }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-warning" id="buyTicketButton">Buy Tiket</button>
        </div>
    </div>
    </div>
    </div>

    </div>
    </div>
    </div>
    </div>
    </form>

@endsection

@push('css')
    <style>
        /* hide scrollbar for aesthetically purpose */
        .seat-layout-wrap {
            -ms-overflow-style: none;
            /* Internet Explorer 10+ */
            scrollbar-width: nonecheckbox;
            /* Firefox */
        }

        .seat-layout-wrap::-webkit-scrollbar {
            display: none;
            /* Safari and Chrome */
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // calculate ticket detail
            let totalSeatSelected = 0;
            let limitSeatSelected = 6;
            let ticketPrice = $('#ticketPrice').text().trim();
            let totalTicketPrice = 0;

            $('#totalSeats').text(totalSeatSelected);
            $('#totalTickets').text(totalSeatSelected);
            $('#totalTicketPrice').text(totalTicketPrice);

            $('.seatCheckbox').on('change', function() {
                let selectedSeats = [];
                let totalSeatSelected = 0;

                $('.seatCheckbox:checked').each(function() {
                    selectedSeats.push($(this).val());

                });

                totalSeatSelected = selectedSeats.length;

                if (totalSeatSelected > limitSeatSelected) {
                    // Uncheck the last selected checkbox if the limit is exceeded
                    $(this).prop('checked', false);
                    alert('Masimal 6 tiket');

                    $('#totalSeatsAlert').text("Maskimal 6 tiket");


                    return;
                }

                totalTicketPrice = ticketPrice * totalSeatSelected;

                // return all calculated value
                $('#selectedSeats').html(selectedSeats.join(', '));
                $('#totalSeats').text(totalSeatSelected);
                $('#totalTickets').text(totalSeatSelected);
                $('#totalTicketPrice').text(totalTicketPrice);
            });

            // check before buy ticket
            $('#buyTicketButton').on('click', function() {
                confirm(
                    'Apakah kamu yakin?\n\nPastikan kamu sudah memilih tiket dan tempat duduk yang benar dan sesuai keinginan'
                );

                return;
            })
        });
    </script>
@endpush
