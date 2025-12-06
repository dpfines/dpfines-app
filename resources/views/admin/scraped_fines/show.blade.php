@extends('layout')

@section('content')
<div class="admin-shell">
    @include('admin._sidebar')
    <main class="container-fluid mt-4">
    <div class="page-header mb-4">
        <h1>{{ $scraped_fine->organisation }}</h1>
        <div class="actions">
            @if($scraped_fine->status === 'pending')
                <a href="{{ route('admin.scraped-fines.review', $scraped_fine->id) }}" class="btn btn-warning">Review</a>
            @endif
            <a href="{{ route('admin.scraped-fines.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Fine Details</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Amount:</dt>
                        <dd class="col-sm-9"><strong>{{ $scraped_fine->formatted_amount }}</strong></dd>

                        <dt class="col-sm-3">Date:</dt>
                        <dd class="col-sm-9">{{ $scraped_fine->fine_date?->format('M d, Y') }}</dd>

                        <dt class="col-sm-3">Regulator:</dt>
                        <dd class="col-sm-9">{{ $scraped_fine->regulator ?? '-' }}</dd>

                        <dt class="col-sm-3">Sector:</dt>
                        <dd class="col-sm-9">{{ $scraped_fine->sector ?? '-' }}</dd>

                        <dt class="col-sm-3">Region:</dt>
                        <dd class="col-sm-9">{{ $scraped_fine->region ?? '-' }}</dd>

                        <dt class="col-sm-3">Violation Type:</dt>
                        <dd class="col-sm-9">{{ $scraped_fine->violation_type ?? '-' }}</dd>

                        <dt class="col-sm-3">Law:</dt>
                        <dd class="col-sm-9">{{ $scraped_fine->law ?? '-' }}</dd>

                        <dt class="col-sm-3">Articles Breached:</dt>
                        <dd class="col-sm-9">{{ $scraped_fine->articles_breached ?? '-' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Summary</h5>
                </div>
                <div class="card-body">
                    {{ $scraped_fine->summary }}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Status</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Status:</strong>
                        @if($scraped_fine->status === 'pending')
                            <span class="badge bg-warning">Pending Review</span>
                        @elseif($scraped_fine->status === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </p>

                    @if($scraped_fine->reviewed_by)
                        <p class="mb-2">
                            <strong>Reviewed By:</strong>
                            {{ $scraped_fine->reviewedBy?->name ?? 'System' }}
                        </p>
                        <p class="mb-2">
                            <strong>Reviewed At:</strong>
                            {{ $scraped_fine->reviewed_at?->format('M d, Y H:i') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Submission</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Submitted By:</strong>
                        {{ $scraped_fine->submittedBy->name }}
                    </p>
                    <p class="mb-0">
                        <strong>Submitted At:</strong>
                        {{ $scraped_fine->created_at?->format('M d, Y H:i') }}
                    </p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Badges</h5>
                </div>
                <div class="card-body">
                    @if($scraped_fine->badges_array)
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($scraped_fine->badges_array as $badge)
                                <span class="badge bg-primary">{{ trim($badge) }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No badges</p>
                    @endif
                </div>
            </div>

            @if($scraped_fine->review_notes)
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Review Notes</h5>
                    </div>
                    <div class="card-body">
                        {{ $scraped_fine->review_notes }}
                    </div>
                </div>
            @endif
        </div>
    </div>
    </main>
</div>
@endsection
