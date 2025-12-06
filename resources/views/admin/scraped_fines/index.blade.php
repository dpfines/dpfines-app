@extends('layout')

@section('content')
<div class="admin-shell">
    @include('admin._sidebar')
    <main class="container-fluid mt-4">
    <div class="page-header mb-4">
        <h1>Scraped Fines Review</h1>
        <div class="actions">
            <a href="{{ route('admin.scraped-fines.create') }}" class="btn btn-primary">Find New Fines</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Dashboard</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Status Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-auto">
                    <label class="form-label">Filter by Status:</label>
                </div>
                @foreach($statuses as $status)
                    <div class="col-auto">
                        <a href="{{ route('admin.scraped-fines.index', ['status' => $status]) }}"
                           class="btn btn-sm {{ request('status') === $status || (request('status') === null && $status === 'pending') ? 'btn-' . ($status === 'approved' ? 'success' : ($status === 'rejected' ? 'danger' : 'warning')) : 'btn-outline-secondary' }}">
                            {{ ucfirst($status) }}
                            <span class="badge bg-dark">
                                @if($status === 'pending')
                                    {{ \App\Models\ScrapedFine::pending()->count() }}
                                @elseif($status === 'approved')
                                    {{ \App\Models\ScrapedFine::approved()->count() }}
                                @else
                                    {{ \App\Models\ScrapedFine::rejected()->count() }}
                                @endif
                            </span>
                        </a>
                    </div>
                @endforeach
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-outline-primary">Search</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Fines Table -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Organisation</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Submitted By</th>
                    <th>Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($scraped_fines as $fine)
                    <tr>
                        <td><strong>{{ Str::limit($fine->organisation, 25) }}</strong></td>
                        <td>{{ $fine->formatted_amount }}</td>
                        <td>{{ $fine->fine_date?->format('M d, Y') ?? '-' }}</td>
                        <td>
                            @if($fine->status === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($fine->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>{{ $fine->submittedBy->name }}</td>
                        <td>{{ $fine->created_at?->diffForHumans() ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.scraped-fines.show', $fine->id) }}" class="btn btn-sm btn-info">View</a>
                            @if($fine->status === 'pending')
                                <a href="{{ route('admin.scraped-fines.review', $fine->id) }}" class="btn btn-sm btn-warning">Review</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No fines found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $scraped_fines->links() }}
    </div>
    </main>
</div>
@endsection
