@extends('layout')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="admin-shell">

    {{-- Sidebar --}}
    @include('admin._sidebar')

    {{-- Main Content --}}
    <div class="admin-content">

        {{-- Page Header --}}
        <div class="page-header mb-4">
            <div>
                <h1> Admin Dashboard</h1>
                <p class="text-muted mb-0">Overview of fines & review activity</p>
            </div>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            {{ session('success') }}
            <button type="button" class="btn-close"></button>
        </div>
        @endif

        {{-- Metrics Grid --}}
        <div class="metrics-grid mb-4">
            @php
            $metrics = [
            ['title'=>'Total Published Fines', 'value'=>$stats['total_fines'], 'icon'=>'fa-gavel', 'link'=>route('admin.fines.index')],
            ['title'=>'Scraped Items', 'value'=>$stats['total_scraped'], 'icon'=>'fa-file-import', 'link'=>route('admin.scraped-fines.index')],
            ['title'=>'Pending Reviews', 'value'=>$stats['pending_reviews'], 'icon'=>'fa-hourglass-half', 'link'=>route('admin.scraped-fines.index', ['status'=>'pending']), 'class'=>'text-warning'],
            ['title'=>'Approved This Month', 'value'=>$stats['approved_fines'], 'icon'=>'fa-check-circle', 'link'=>route('admin.scraped-fines.index', ['status'=>'approved']), 'class'=>'text-success'],
            ];
            @endphp

            @foreach($metrics as $metric)
            <a href="{{ $metric['link'] }}" class="metric-link">
                <div class="metric-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small-muted">{{ $metric['title'] }}</div>
                            <div class="h3 mt-1 {{ $metric['class'] ?? '' }}">{{ number_format($metric['value']) }}</div>
                        </div>
                        <div class="avatar-sm">
                            <i class="fa-solid {{ $metric['icon'] }}"></i>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach

            {{-- Sparkline --}}
            <div class="sparkline-wrapper">
                <svg id="sparkline" width="100%" height="48" viewBox="0 0 200 48" preserveAspectRatio="none"></svg>
            </div>
        </div>

        {{-- Dashboard Main Grid --}}
        <div class="dashboard-grid">

            {{-- Left Column --}}
            <div class="dashboard-left">

                {{-- Hero Card --}}
                <div class="card card-hero mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4>Welcome back, Admin</h4>
                            <div class="small-muted">Quick summary and recent activity</div>
                        </div>
                        <div class="text-end">
                            <div class="small-muted">Today</div>
                            <div class="h5 mt-1">{{ now()->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>

                {{-- Recent Scraped --}}
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="mb-3">Recent Scraped Fines</h5>
                        @forelse($recent_scraped as $fine)
                        <div class="list-group-item d-flex justify-content-between align-items-center hover-card">
                            <div>
                                <div class="fw-bold">{{ Str::limit($fine->organisation, 40) }}</div>
                                <div class="small-muted">{{ $fine->regulator }} • {{ $fine->fine_date?->format('Y-m-d') }}</div>
                            </div>
                            <div class="text-end">
                                <div class="small-muted">{{ $fine->formatted_amount }}</div>
                                <div class="mt-1 d-flex gap-1 justify-content-end">
                                    <a href="{{ route('admin.scraped-fines.show', $fine->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                    <a href="{{ route('admin.scraped-fines.review', $fine->id) }}" class="btn btn-sm btn-warning">Review</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <i class="fa-solid fa-folder-open"></i>
                            <p>No recent scraped fines.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- Top Regulators --}}
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="mb-3">Top Regulators</h5>
                        @forelse($top_regulators as $reg)
                        <div class="d-flex justify-content-between align-items-center py-1 hover-card">
                            <div>{{ $reg->regulator }}</div>
                            <div class="small-muted">{{ $reg->total }}</div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <i class="fa-solid fa-chart-line"></i>
                            <p>No regulator data available.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- Pending Reviews Table --}}
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Pending Reviews</h5>
                        @if($pending_reviews->isEmpty())
                        <div class="empty-state">
                            <i class="fa-solid fa-inbox"></i>
                            <p>No pending reviews.</p>
                        </div>
                        @else
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Organisation</th>
                                        <th>Amount</th>
                                        <th>Submitted</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pending_reviews as $fine)
                                    <tr class="hover-card">
                                        <td>{{ Str::limit($fine->organisation, 30) }}</td>
                                        <td>{{ $fine->formatted_amount }}</td>
                                        <td class="small-muted">{{ $fine->submittedBy?->name }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.scraped-fines.review', $fine->id) }}" class="btn btn-sm btn-warning">Review</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Right Column / Aside --}}
            <aside class="dashboard-right">

                {{-- Quick Actions --}}
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="mb-2">Quick Actions</h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.fines.create') }}" class="btn btn-primary">Add Global Fine</a>
                            <a href="{{ route('admin.fines.index') }}" class="btn btn-outline-primary">Manage Fines</a>
                            <a href="{{ route('admin.scraped-fines.index') }}" class="btn btn-outline-secondary">Review Scraped</a>
                        </div>
                    </div>
                </div>

                {{-- Support --}}
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-2">Support</h6>
                        <p class="text-muted">Need an audit or export? Contact the dev team.</p>
                        <a href="mailto:admin@dpfines.local" class="btn btn-sm btn-outline-secondary w-100">Contact</a>
                    </div>
                </div>

            </aside>

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    (function() {
        const monthly = @json($monthlyApproved ?? []);
        const svg = document.getElementById('sparkline');
        if (!svg || !monthly.length) return;

        const w = 200,
            h = 48,
            max = Math.max(...monthly, 1);
        const points = monthly.map((v, i) => {
            const x = (i / (monthly.length - 1)) * w;
            const y = h - (v / max) * (h - 8) - 4;
            return `${x},${y}`;
        }).join(' ');

        svg.innerHTML = `<polyline points="${points}" fill="none" stroke="#4b5563" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />`;
    })();
</script>
@endpush