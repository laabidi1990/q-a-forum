@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-5 h5" role="alert">
        <strong>Success: </strong>{{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif