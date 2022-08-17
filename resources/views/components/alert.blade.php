<div class="alert {{ $type }} alert-dismissible my-2" role="alert">
    <div class="d-flex">
        <div>
            <h4 class="alert-title">{{ $title }}</h4>
            <div class="text-muted">
                {{ $slot }}
            </div>
        </div>
    </div>
    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
</div>
