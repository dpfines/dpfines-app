@extends('layout')

@section('content')
<div class="admin-shell">
    @include('admin._sidebar')
    <main class="container-fluid mt-4">
    <div class="page-header mb-4">
        <h1>Review: {{ $scraped_fine->organisation }}</h1>
        <div class="actions">
            <a href="{{ route('admin.scraped-fines.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <strong>Error:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

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

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Summary</h5>
                </div>
                <div class="card-body">
                    {{ $scraped_fine->summary }}
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Review Decision</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.scraped-fines.store-review', $scraped_fine->id) }}" method="POST" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Decision *</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="status" id="approve" value="approved" required>
                                <label class="btn btn-outline-success w-50" for="approve">
                                    ✓ Approve
                                </label>

                                <input type="radio" class="btn-check" name="status" id="reject" value="rejected" required>
                                <label class="btn btn-outline-danger w-50" for="reject">
                                    ✗ Reject
                                </label>
                            </div>
                            @error('status')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="review_notes" class="form-label">Review Notes *</label>
                            <textarea class="form-control @error('review_notes') is-invalid @enderror"
                                      id="review_notes" name="review_notes" rows="4"
                                      placeholder="Explain your decision..."
                                      required minlength="10" maxlength="2000">{{ old('review_notes') }}</textarea>
                            @error('review_notes')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                Provide reasons for approval or rejection (minimum 10 characters)
                            </small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Submit Review</button>
                            <a href="{{ route('admin.scraped-fines.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Submission Info</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5">Submitted By:</dt>
                        <dd class="col-sm-7">{{ $scraped_fine->submittedBy->name }}</dd>

                        <dt class="col-sm-5">Submitted At:</dt>
                        <dd class="col-sm-7">{{ $scraped_fine->created_at?->format('M d, Y H:i') }}</dd>

                        <dt class="col-sm-5">Status:</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-warning">Pending Review</span>
                        </dd>
                    </dl>
                </div>
            </div>

            <div class="card">
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
        </div>
    </div>
    </main>
</div>
@endsection
