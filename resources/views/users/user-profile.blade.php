@extends('layouts.app')

@section('content')
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-4">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('images/cesar-rincon.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><span class="badge bg-primary">{{ $user->name }}</span></h5>
                        <p>Username : <span class="badge bg-primary">{{ $user->username }}</span></p>
                        <p>Email : <span class="badge bg-primary">{{ $user->email }}</span></p>
                        <p>Birthday : <span class="badge bg-primary">{{ $userBirthDay }}</span></p>
                        <p>Current Balance : <span class="badge bg-warning">{{ $user->balance ?? '0' }}</span></p>
                        <a href="#" class="btn btn-success">Top up Balance</a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <p class="h1">Ticket Transaction History</p>
            </div>
        </div>

    </div>
@endsection
