@extends('layout')

@section('content')
<div class="admin-shell">
    @include('admin._sidebar')
    <main class="container-fluid mt-4">
    <div class="page-header mb-4">
        <h1>{{ $fine->organisation }}</h1>
        <div class="actions">
            <a href="{{ route('admin.fines.edit', $fine->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('admin.fines.destroy', $fine->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Confirm delete?')">Delete</button>
            </form>
            <a href="{{ route('admin.fines.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Fine Details</h5>
                    <dl class="row">
                        <dt class="col-sm-3">Amount:</dt>
                        <dd class="col-sm-9"><strong>{{ $fine->formatted_amount }}</strong></dd>

                        <dt class="col-sm-3">Date:</dt>
                        <dd class="col-sm-9">{{ $fine->fine_date?->format('M d, Y') }}</dd>

                        <dt class="col-sm-3">Regulator:</dt>
                        <dd class="col-sm-9">{{ $fine->regulator ?? '-' }}</dd>

                        <dt class="col-sm-3">Sector:</dt>
                        <dd class="col-sm-9">{{ $fine->sector ?? '-' }}</dd>

                        <dt class="col-sm-3">Region:</dt>
                        <dd class="col-sm-9">{{ $fine->region ?? '-' }}</dd>

                        <dt class="col-sm-3">Violation Type:</dt>
                        <dd class="col-sm-9">{{ $fine->violation_type ?? '-' }}</dd>

                        <dt class="col-sm-3">Law:</dt>
                        <dd class="col-sm-9">{{ $fine->law ?? '-' }}</dd>

                        <dt class="col-sm-3">Articles Breached:</dt>
                        <dd class="col-sm-9">{{ $fine->articles_breached ?? '-' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Summary</h5>
                    <p>{{ $fine->summary }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Badges</h5>
                    @if($fine->badges_array)
                        <div>
                            @foreach($fine->badges_array as $badge)
                                <span class="badge bg-primary">{{ $badge }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No badges</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Case Reference</h5>
                    @if($fine->link_to_case)
                        <a href="{{ $fine->link_to_case }}" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                            View Official Case
                        </a>
                    @else
                        <p class="text-muted">No case reference</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </main>
</div>
@endsection
