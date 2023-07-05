@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div>
            <p class="h1">Top Up Balance History</p>
            <p>all history</p>
        </div>

        <div class="row">
            @foreach ($ticketTransactionHistory->chunk(3) as $ticketTransactionHistoryChunk)
                @foreach ($ticketTransactionHistoryChunk as $item)
                    <div class="col-4">
                        <div class="alert alert-info">
                            <div>
                                <p>Top Up Date : <span
                                        class="badge bg-primary">{{ date('d F Y - h:m:s', strtotime($item->created_at)) }}</span>
                                </p>
                                <p>Film Title : <span class="badge bg-primary">{{ $item->movie_title }}</span></p>
                                <p>Seat Number : <span class="badge bg-primary">{{ $item->seat_number }}</span></p>
                                <p>Status : <span
                                        class="badge {{ $item->status === '1' ? 'bg-success' : 'bg-danger' }}">{{ $item->status === App\Enum\TicketStatusEnum::SUCCESS ? 'Success' : 'Canceled' }}</span>
                                </p>
                                <a href="{{ route('tickets.detail', [auth()->user()->username, $item->xid]) }}" class="btn btn-primary">Get Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    <section class="container mt-2">
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item">
                    <a href="{{ $ticketTransactionHistory->previousPageUrl() }}" class="page-link">
                        Previous
                    </a>
                </li>
                @for ($i = 1; $i <= $ticketTransactionHistory->lastPage(); $i++)
                    <li class="page-item {{ $ticketTransactionHistory->currentPage() == $i ? 'active' : '' }}">
                        <a href="{{ $ticketTransactionHistory->url($i) }}" class="page-link">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item">
                    <a href="{{ $ticketTransactionHistory->nextPageUrl() }}" class="page-link">
                        Next
                    </a>
                </li>
            </ul>
        </nav>
    </section>

    <section class="container">
        <a href="{{ route('user.profile', auth()->user()->username) }}" class="btn btn-secondary">Kembali</a>
    </section>
@endsection
