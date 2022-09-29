@if ($status == 'approved')
    <span class="badge rounded-pill text-bg-success">APPROVED</span>
@endif

@if ($status == 'rejected')
    <span class="badge rounded-pill text-bg-danger">REJECTED</span>
@endif

@if ($status == 'pending')
    <span class="badge rounded-pill text-bg-warning">PENDING</span>
@endif
