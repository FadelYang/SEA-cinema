<div class="row">
    @if ( sizeOf($movies) == 0)
        <div class="text-center">
            - Judul Film Tidak Ditemukan -
        </div>
    @endif

    @foreach ($movies->chunk(3) as $movieChunk)
        @foreach ($movieChunk as $movie)
            <div class="row col-xl-6 mb-2">
                <div class="col-sm-6 imageContainer">
                    <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }} poster" class="img-fluid image" title="{{ $movie->title }}">
                    <div class="detailButton">
                        <a class="btn btn-light mb-1" href="{{ route('movie.detail', $movie->title) }}">Lihat Detail</a>
                        <a class="btn btn-dark" href="#">Beli Tiket</a>
                    </div>
                </div>
                <div class="col-sm-6 d-flex flex-column justify-content-xl-between">
                    <div>
                        <p class="h3 mt-2">{{ $movie->title }}</p>
                        <p class="movieDescription">{{ $movie->description }}</p>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p>Release Date: <span
                                    class="badge bg-primary">{{ Carbon\Carbon::createFromFormat('Y-m-d', $movie->release_date)->format('d F Y') }}</span>
                            </p>
                            <p>Age Rating: <span class="badge bg-primary">{{ $movie->age_rating }}</span></p>
                            <p>Ticket Price: <span class="badge bg-primary">{{ $movie->ticket_price }}</span></p>
                        </div>
                        <div class="col-12 d-xl-none detailButtonResponsive">
                            <a class="btn btn-light" href="{{ route('movie.detail', $movie->title) }}">Lihat Detail</a>
                            <a class="btn btn-warning" href="#">Beli Tiket</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
</div>
