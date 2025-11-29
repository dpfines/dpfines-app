@extends('layout')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

{{-- DASHBOARD HEADER --}}
<section class="dashboard-hero">
    <div class="container">
        <div class="dashboard-header">
            <h1><i class="fas fa-chart-line"></i> Analytics & Dashboards</h1>
            <p>Comprehensive insights into global data protection enforcement trends</p>
        </div>
    </div>
</section>

{{-- KEY METRICS --}}
<section class="dashboard-section" id="section-keymetrics">
    <div class="container">
        <div class="section-header">
            <h2>Key Metrics</h2>
            <div class="section-tools">
                <button class="section-download btn btn-text" data-target="#section-keymetrics" title="Download Key Metrics as PNG" aria-label="Download Key Metrics"><i class="fas fa-download"></i></button>
            </div>
        </div>
        <div class="metrics-grid">
            <div class="metric-card">
                <div class="metric-icon blue">
                    <i class="fas fa-gavel"></i>
                </div>
                <div class="metric-content">
                    <div class="metric-value">{{ number_format($totalFines) }}</div>
                    <div class="metric-label">Total Enforcement Actions</div>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-icon purple">
                    <i class="fas fa-euro-sign"></i>
                </div>
                <div class="metric-content">
                    <div class="metric-value">{{ $formattedTotal ?? ('€' . number_format($totalAmount / 1000000000, 1) . 'B') }}</div>
                    <div class="metric-label">Total Fines Issued</div>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-icon green">
                    <i class="fas fa-calculator"></i>
                </div>
                <div class="metric-content">
                    <div class="metric-value">{{ $formattedAverage ?? ('€' . number_format($averageAmount / 1000000, 1) . 'M') }}</div>
                    <div class="metric-label">Average Fine Amount</div>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-icon orange">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="metric-content">
                    <div class="metric-value">{{ $latestFineDate ? \Carbon\Carbon::parse($latestFineDate)->format(format: 'd M Y') : 'N/A' }}</div>
                    <div class="metric-label">Latest Enforcement Action</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TOP REGULATORS (expandable) --}}
<section class="dashboard-section bg-light expandable" id="section-regulators">
    <div class="container">
        <div class="expandable-header">
            <div class="section-header">
                <h2>Top Regulators by Enforcement Actions</h2>
            </div>
            <div class="expand-controls">
                <button class="expand-toggle" aria-expanded="true" aria-label="Collapse section">
                    <i class="fas fa-chevron-up" aria-hidden="true"></i>
                </button>
                <button class="section-download btn btn-text" data-target="#section-regulators" title="Download Regulators section" aria-label="Download Regulators"><i class="fas fa-download"></i></button>
            </div>
        </div>

        <div class="expandable-body">

        <div class="dashboard-grid">
            <div class="chart-container">
                <x-bar-list
                    :items="$regulatorStats"
                    title="regulator"
                    compare="count"
                    color="bar-fill-blue"
                    :stats="[
                        ['key' => 'count', 'suffix' => ' cases', 'class' => 'stat-count'],
                        ['key' => 'formatted_total', 'suffix' => '', 'class' => 'stat-amount'],
                    ]"
                />
            </div>

            <div class="stat-table">
                <table>
                    <thead>
                        <tr>
                            <th>Regulator</th>
                            <th>Cases</th>
                            <th>Total Amount</th>
                            <th>Avg Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($regulatorStats as $stat)
                            <tr>
                                <td>{{ $stat->regulator }}</td>
                                <td><span class="badge">{{ $stat->count }}</span></td>
                                <td>{{ $stat->formatted_total ?? ('€' . number_format($stat->total_amount / 1000000, 1) . 'M') }}</td>
                                <td>{{ isset($stat->count) && $stat->count ? ('€' . number_format($stat->total_amount / $stat->count / 1000000, 1) . 'M') : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        </div> <!-- /.expandable-body -->
    </div>
</section>

{{-- SECTORS & VIOLATION TYPES --}}
<section class="dashboard-section" id="section-sectors">
    <div class="container">

        <div class="section-tools" style="display:flex;justify-content:flex-end;margin-bottom:.5rem">
            <button class="section-download btn btn-text" data-target="#section-sectors" title="Download Sectors & Violations" aria-label="Download Sectors and Violations"><i class="fas fa-download"></i></button>
        </div>
        <div class="charts-two-column">
            {{-- SECTORS --}}
            <div>
                <h3>Most Fined Sectors</h3>
                <x-bar-list
                    :items="$sectorStats"
                    title="sector"
                    compare="count"
                    color="bar-fill-purple"
                    id="sectors-list"
                    :stats="[
                        ['key' => 'count', 'suffix' => ' cases', 'class' => 'stat-count'],
                    ]"
                />
            </div>

            {{-- VIOLATION TYPES --}}
            <div>
                <h3>Violation Types</h3>
                <x-bar-list
                    :items="$violationStats"
                    title="violation_type"
                    compare="count"
                    color="bar-fill-indigo"
                    id="violations-list"
                    :stats="[
                        ['key' => 'count', 'suffix' => ' cases', 'class' => 'stat-count'],
                    ]"
                />
            </div>
        </div>
    </div>
</section>

{{-- YEARLY TRENDS (expandable) --}}
<section class="dashboard-section bg-light expandable" id="section-yearly">
    <div class="container">
        <div class="expandable-header">
            <h2>Enforcement Actions by Year</h2>
            <div class="expand-controls">
                <button class="expand-toggle" aria-expanded="true" aria-label="Collapse section">
                    <i class="fas fa-chevron-up" aria-hidden="true"></i>
                </button>
                <button class="section-download btn btn-text" data-target="#section-yearly" title="Download Yearly trends" aria-label="Download Yearly Trends"><i class="fas fa-download"></i></button>
            </div>
        </div>

        <div class="expandable-body">
            <x-bar-list
                :items="$yearlyStats"
                title="year"
                compare="count"
                color="bar-fill-green"
                :stats="[
                    ['key' => 'count', 'suffix' => ' cases', 'class' => 'stat-count'],
                    ['key' => 'formatted_total', 'suffix' => '', 'class' => 'stat-amount'],
                ]"
            />
        </div>
    </div>
</section>

{{-- REGIONAL BREAKDOWN (expandable) --}}
<section class="dashboard-section expandable" id="section-regions">
    <div class="container">
        <div class="expandable-header">
            <h2>Enforcement Actions by Region</h2>
            <div class="expand-controls">
                <button class="expand-toggle" aria-expanded="true" aria-label="Collapse section">
                    <i class="fas fa-chevron-up" aria-hidden="true"></i>
                </button>
                <button class="section-download btn btn-text" data-target="#section-regions" title="Download Regions" aria-label="Download Regions"><i class="fas fa-download"></i></button>
            </div>
        </div>

        <div class="expandable-body">
            <div class="dashboard-grid">
                <x-bar-list
                    :items="$regionStats"
                    title="region"
                    compare="count"
                    color="bar-fill-teal"
                    :stats="[
                        ['key' => 'count', 'suffix' => ' cases', 'class' => 'stat-count'],
                        ['key' => 'formatted_total', 'suffix' => '', 'class' => 'stat-amount'],
                    ]"
                />
            </div>
        </div>
    </div>
</section>

{{-- TOP ORGANIZATIONS (expandable) --}}
<section class="dashboard-section bg-light expandable" id="section-organizations">
    <div class="container">
        <div class="expandable-header">
            <h2>Most Fined Organizations</h2>
            <div class="expand-controls">
                <button class="expand-toggle" aria-expanded="true" aria-label="Collapse section">
                    <i class="fas fa-chevron-up" aria-hidden="true"></i>
                </button>
                <button class="section-download btn btn-text" data-target="#section-organizations" title="Download Organizations" aria-label="Download Organizations"><i class="fas fa-download"></i></button>
            </div>
        </div>

        <div class="expandable-body">
            <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Organization</th>
                        <th>Sector</th>
                        <th>Regulator</th>
                        <th>Cases</th>
                        <th>Total Fines</th>
                        <th>Avg Fine</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topOrganizations as $org)
                        <tr>
                            <td><strong>{{ $org->organisation }}</strong></td>
                            <td>{{ $org->sector }}</td>
                            <td>{{ $org->regulator }}</td>
                            <td><span class="badge">{{ $org->count }}</span></td>
                            <td>€{{ number_format($org->total_amount / 1000000, 1) }}M</td>
                            <td>€{{ number_format($org->total_amount / $org->count / 1000000, 1) }}M</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>
</section>

{{-- LARGEST FINES (expandable) --}}
<section class="dashboard-section expandable" id="section-largest">
    <div class="container">
        <div class="expandable-header">
            <h2>Largest Individual Fines</h2>
            <div class="expand-controls">
                <button class="expand-toggle" aria-expanded="true" aria-label="Collapse section">
                    <i class="fas fa-chevron-up" aria-hidden="true"></i>
                </button>
                <button class="section-download btn btn-text" data-target="#section-largest" title="Download Largest fines" aria-label="Download Largest Fines"><i class="fas fa-download"></i></button>
            </div>
        </div>

        <div class="expandable-body">
            <div class="largest-fines-grid">
            @forelse($largestFines as $fine)
                <div class="fine-record-card">
                    <div class="fine-record-header">
                        <h3>{{ $fine->organisation }}</h3>
                        <div class="fine-amount-badge">€{{ number_format($fine->fine_amount / 1000000, 1) }}M</div>
                    </div>
                    <div class="fine-record-body">
                        <div class="record-item">
                            <span class="label">Regulator:</span>
                            <span class="value">{{ $fine->regulator }}</span>
                        </div>
                        <div class="record-item">
                            <span class="label">Sector:</span>
                            <span class="value">{{ $fine->sector }}</span>
                        </div>
                        <div class="record-item">
                            <span class="label">Date:</span>
                            <span class="value">{{ \Carbon\Carbon::parse($fine->fine_date)->format('M d, Y') }}</span>
                        </div>
                        <div class="record-item">
                            <span class="label">Violation Type:</span>
                            <span class="value"><span class="badge badge-red">{{ $fine->violation_type }}</span></span>
                        </div>
                        <div class="record-item">
                            <span class="label">Law:</span>
                            <span class="value">{{ $fine->law }}</span>
                        </div>
                    </div>
                    <div class="fine-record-footer">
                        <a href="{{ route('fine.show', $fine->id) }}" class="btn btn-primary btn-sm">
                            View Details
                        </a>
                        <a href="{{ $fine->link_to_case }}" target="_blank" class="btn btn-secondary btn-sm">
                            External Source
                        </a>
                    </div>
                </div>
            @empty
                <p class="no-data">No data available</p>
            @endforelse
        </div>
    </div>
</section>

{{-- CTA SECTION --}}
<section class="dashboard-cta">
    <div class="container">
        <h2>Explore More</h2>
        <p>Dive deeper into the enforcement data and find specific cases relevant to your organization</p>
        <div class="cta-buttons">
            <a href="/database" class="btn btn-primary btn-large">
                <i class=""></i> Browse Full Database
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script>
    // Expose prepared dashboard data for client-side exporters (XLSX)
    window.__dashboardData = {!! json_encode($dashboardData ?? []) !!};
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
@endpush

@endsection
