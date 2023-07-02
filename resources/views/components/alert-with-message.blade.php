@if (session('message') || session('error'))
    <div class="col-md-12">
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
    </div>
@endif

@if (session('success') || session('error'))
    <div class="col-md-12">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div>
@endif
