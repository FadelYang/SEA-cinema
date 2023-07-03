@if (session('message') || session('error'))
    <div class="col-md-12 alert-message">
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
    </div>
@endif

@if (session('success') || session('error'))
    <div class="col-md-12 alert-message">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div>
@endif

@push('js')
    <script>
        $("document").ready(function() {
            setTimeout(function() {
                $(".alert-message").fadeOut();
            }, 10000);
        });
    </script>
@endpush
