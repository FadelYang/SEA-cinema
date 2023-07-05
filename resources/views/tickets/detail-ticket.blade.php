@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <p>Hola amigos</p>

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
                            class="badge {{ $ticketItem->status === 1 ? 'bg-success' : 'bg-danger' }}">{{ $ticketItem->status === 1 ? 'Success' : 'Canceled' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <section class="container">
        <a href="{{ route('user.profile', auth()->user()->username) }}" class="btn btn-secondary">Kembali</a>
        <a href="#" class="btn btn-danger">Cancel Ticket</a>
    </section>
@endsection
