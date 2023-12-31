@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div>
            <p class="h1">Top Up Balance History</p>
            <p>all history</p>
        </div>

        <div class="row">
            @foreach ($topUpBalanceHistory->chunk(3) as $topUpBalanceHistoryChunk)
                @foreach ($topUpBalanceHistoryChunk as $item)
                    <div class="col-4">
                        <div class="alert alert-info">
                            <div>
                                <p>Top Up Date : <span
                                        class="badge bg-primary">{{ date('d F Y - h:m:s', strtotime($item->created_at)) }}</span>
                                </p>
                                <p>Top Up Amount : <span class="badge bg-primary">{{ $item->amount }}</span></p>
                                <p>Notes : <span
                                            class="badge bg-primary">{{ $item->notes == null ? 'tidak ada catatan ' : $item->notes }}</span></p>
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
                    <a href="{{ $topUpBalanceHistory->previousPageUrl() }}" class="page-link">
                        Previous
                    </a>
                </li>
                @for ($i = 1; $i <= $topUpBalanceHistory->lastPage(); $i++)
                    <li class="page-item {{ $topUpBalanceHistory->currentPage() == $i ? 'active' : '' }}">
                        <a href="{{ $topUpBalanceHistory->url($i) }}" class="page-link">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item">
                    <a href="{{ $topUpBalanceHistory->nextPageUrl() }}" class="page-link">
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
