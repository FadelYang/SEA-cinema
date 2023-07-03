@extends('layouts.app')

@section('content')
    <div class="container mt-5 pt-5">
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
                        <p class="alert alert-info p-5 text-center ">There will appears transaction history here</p>
                    </div>
                    <div class="mt-xl-5 mt-2">
                        <p class="h1">Top Up Balance History</p>
                        <p>Latest transaction</p>
                        <div class="alert alert-info">
                            @if (is_null($topUpBalanceHistory))
                                <div class="text-center">Belum ada history transaksi</div>
                            @else
                                <div>
                                    <p>Top Up Date : <span
                                            class="badge bg-primary">{{ date('d F Y', strtotime($topUpBalanceHistory->created_at)) }}</span>
                                    </p>
                                    <p>Top Up Amount : <span
                                            class="badge bg-primary">{{ $topUpBalanceHistory->amount }}</span></p>
                                </div>
                        </div>
                        <a href="#" class="btn btn-warning">See All Transaction</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
