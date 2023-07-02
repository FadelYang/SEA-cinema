@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <p class="h3 text-center bg-primary py-2 text-white">Seat Layout</p>


                <div class="overflow-scroll seat-layout-wrap">
                    <p class="text-center m-5">SCREEN</p>
                    <div class="btn-group mt-5" role="group" aria-label="Basic checkbox toggle button group">
                        @for ($row = 1; $row <= 9; $row++)
                            <div class="row">
                                @for ($col = 1; $col <= 7; $col++)
                                    <div class="col my-1 mx-sm-0 mx-1">
                                        <input type="checkbox" class="btn-check smallCheckbox seatCheckbox"
                                            id="btncheck{{ $row }}{{ $col }}" autocomplete="off"
                                            name="seats" value="{{ chr(64 + $col) }}{{ $row }}">
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

            <div class="col-md-4 mt-sm-0 mt-5">
                <div class="row">
                    <div class="col-12">
                        <p class="h3 text-center mb-3 bg-primary py-2 text-white">Film Detail</p>

                        @foreach ($movie as $movie)
                            {{-- detail movie section --}}
                            <p class="h5">Title : <span class="badge bg-primary">{{ $movie->title }}</span>
                            </p>
                            <p class="h5">Release Date : <span
                                    class="badge bg-primary">{{ Carbon\Carbon::createFromFormat('Y-m-d', $movie->release_date)->format('d F Y') }}</span>
                            </p>
                            <p class="h5">Ticket Price : <span
                                    class="badge bg-primary">{{ $movie->ticket_price }}</span></p>
                            <p class="h5">Age Rating : <span class="badge bg-primary">{{ $movie->age_rating }}</span>
                        @endforeach
                    </div>
                    <div class="col-12 mt-2 ">
                        <div>
                            <p class="h3 text-center mb-3 bg-primary py-2 text-white">Ticket Detail</p>

                            <p class="h5">Seat(s) Selected : <span id="selectedSeats" class="badge bg-primary"></span>
                            </p>
                            <p class="h5">Total Seat(s) : <span id="totalSeats"
                                    class="badge bg-primary totalSeats"></span>
                                <span id="totalSeatsAlert" class="badge bg-danger"></span>
                            </p>
                            <p class="h5">Price Per Ticket : <span class="badge bg-primary"
                                    id="ticketPrice">{{ $movie->ticket_price }}</span></p>
                            <p class="h5">Ticket Total : <span class="badge bg-primary" id="totalTickets"></span></p>
                            <br>
                            <p class="h5"><strong>Total Price : <span id="totalTicketPrice"
                                        class="badge bg-primary"></span></strong></p>
                        </div>
                        <div>
                            <a href="{{ route('movie.detail', $movie->title) }}" class="btn btn-secondary">Kembali</a>
                            <button href="#" class="btn btn-warning" id="buyTicketButton">Buy Tiket</button>
                        </div>
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
                confirm('Apakah kamu yakin?\n\nPastikan kamu sudah memilih tiket dan tempat duduk yang benar dan sesuai keinginan');

                return;
            })
        });
    </script>
@endpush
