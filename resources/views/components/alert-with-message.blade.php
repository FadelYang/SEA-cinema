@if (session('message') || session('error'))
    <div class="col-md-12">
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
    </div>
@endif
