@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @include('components.alert-with-message')
        <p class="h1">Ticket Detail</p>

        <div class="col-sm-4">
            <div class="alert alert-info">
                <div>
                    <p>Top Up Date : <span
                            class="badge bg-primary">{{ date('d F Y - h:m:s', strtotime($ticketItem->created_at)) }}</span>
                    </p>
                    <p>Film Title : <span class="badge bg-primary">{{ $ticketItem->movie_title }}</span></p>
                    <p>Seat Number : <span class="badge bg-primary">{{ $ticketItem->seat_number }}</span></p>
                    <p>Ticket Price : <span class="badge bg-primary">{{ $ticketItem->ticket_price }}</span></p>
                    <p>Status : <span
                            class="badge {{ $ticketItem->status === App\Enum\TicketStatusEnum::SUCCESS->value ? 'bg-success' : 'bg-danger' }}">{{ $ticketItem->status === App\Enum\TicketStatusEnum::SUCCESS->value ? 'Success' : 'Canceled' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <section class="container">
        <a href="{{ route('user.profile', auth()->user()->username) }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('tickets.cancel-ticket', [auth()->user()->username, $ticketItem->xid]) }}" class="btn btn-danger"
            id="ticketCancelButton">Cancel Ticket</a>
    </section>
@endsection


@push('js')
    <script>
        $(document).ready(function() {
            $('#ticketCancelButton').on('click', function() {
                statusConfirmation = confirm(
                    'Apakah kamu yakin ingin membatalkan pembelian tiket?'
                );

                if (statusConfirmation) {
                    return alert('Tiket anda akan dibatalkan')
                } else {
                    return statusConfirmation
                }
            })
        })
    </script>
@endpush
