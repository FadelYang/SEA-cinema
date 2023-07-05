@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-xl-4">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('images/cesar-rincon.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><span class="badge bg-primary">{{ $user->name }}</span></h5>
                        <p>Username : <span class="badge bg-primary">{{ $user->username }}</span></p>
                        <p>Email : <span class="badge bg-primary">{{ $user->email }}</span></p>
                        <p>Birthday : <span class="badge bg-primary">{{ $userBirthDay }}</span></p>
                        <p>Current Balance : <span class="badge bg-danger">{{ $user->balance ?? '0' }}</span></p>
                        <a href="{{ route('balance.topup-page', Auth::user()->username) }}" class="btn btn-success">Top up
                            Balance</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 mt-xl-0 mt-2">
                <div class="row">
                    <div>
                        <p class="h1">Ticket Transaction History</p>
                        <p>Latest transaction</p>
                        <div class="alert alert-info">
                            @if (is_null($ticketTransactionHistory))
                                <div class="text-center">Belum ada history transaksi</div>
                            @else
                                <div>
                                    <p>Date : <span
                                            class="badge bg-primary">{{ date('d F Y - h:m:s', strtotime($ticketTransactionHistory->created_at)) }}</span>
                                    </p>
                                    <p>Film Title : <span
                                            class="badge bg-primary">{{ $ticketTransactionHistory->movie_title }}</span></p>
                                    <p>Seat Number : <span
                                            class="badge bg-primary">{{ $ticketTransactionHistory->seat_number }}</span></p>
                                <a href="{{ route('tickets.detail', [auth()->user()->username, $ticketTransactionHistory->xid]) }}" class="btn btn-primary">Get Detail</a>
                                </div>
                        </div>
                        <a href="{{ route('tickets.index-history', auth()->user()->username) }}" class="btn btn-warning">See
                            All Transaction</a>
                        @endif
                    </div>
                    <div class="mt-xl-4 mt-2">
                        <p class="h1">Top Up Balance History</p>
                        <p>Latest transaction</p>
                        <div class="alert alert-info">
                            @if (is_null($topUpBalanceHistory))
                                <div class="text-center">Belum ada history transaksi</div>
                            @else
                                <div>
                                    <p>Top Up Date : <span
                                            class="badge bg-primary">{{ date('d F Y - h:m:s', strtotime($topUpBalanceHistory->created_at)) }}</span>
                                    </p>
                                    <p>Top Up Amount : <span
                                            class="badge bg-primary">{{ $topUpBalanceHistory->amount }}</span></p>
                                    <p>Notes : <span
                                            class="badge bg-primary">{{ $topUpBalanceHistory->notes == null ? 'tidak ada catatan ' : $topUpBalanceHistory->notes }}</span></p>
                                </div>
                        </div>
                        <a href="{{ route('balance.index-history', auth()->user()->username) }}"
                            class="btn btn-warning">See All Transaction</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
