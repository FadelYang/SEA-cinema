@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @include('components.alert-with-message')

        <p class="h1">Top Up Balance</p>
    </div>
    <div class="container">
        <form action="{{ route('balance.topup') }}" method="POST" enctype="multipart/form-data" id="topUpBalance">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="topUpBalance" class="form-label">Top Up Balance</label>
                <input type="number" class="form-control w-25" id="topUpBalance" name="balance" aria-describedby="topUpBalanceHelp" required>
                <div id="emailHelp" class="form-text">masukkan jumlah yang mau anda tambahkan. minimal top up 10.000</div>
            </div>

            {{-- <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a> --}}
            <button type="submit" class="btn btn-success">Top Up</button>
        </form>
    </div>
@endsection
