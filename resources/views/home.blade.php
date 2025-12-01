@extends('layout')

@section('content')

<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- HERO SECTION --}}
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text reveal-on-scroll">
                <h1>Track Global Privacy & Data Protection Fines</h1>
                <p>Stay updated on enforcement actions and fines from regulators around the world. Monitor compliance
                    trends and protect your organisation.</p>
                <div class="hero-buttons">
                    <a href="/database" class="btn btn-primary">
                        Explore Fines <i class="fas fa-chevron-right"></i>
                    </a>
                    <a href="/alerts" class="btn btn-secondary">
                        Sign Up for Alerts
                    </a>
                </div>
            </div>
            <div class="hero-image reveal-on-scroll">
                <div class="stats-box">
                    <div class="stat-number">12,500+</div>
                    <div class="stat-label">Enforcement Actions Tracked</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SEARCH + FILTERS --}}
<section class="search-section">
    <div class="container">
        <form action="/database" method="GET" class="search-form">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" name="search"
                    placeholder="Search by organisation, sector, date, GDPR article, or regulation...">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>

            <div class="filters">
                {{-- REGULATOR --}}
                <select name="regulator">
                    <option value="">All Regulators</option>
                    @foreach ([
                    'ICO (UK)',
                    'CNIL (France)',
                    'BfDI (Germany)',
                    'DPC (Ireland)',
                    'AEPD (Spain)',
                    'FTC (USA)',
                    'OAIC (Australia)',
                    'OPC (Canada)',
                    'CNPD (Luxembourg)',
                    'AP (Netherlands)',
                    'Garante (Italy)',
                    'NCSC (Norway)',
                    'IMY (Sweden)',
                    'Datatilsynet (Denmark)',
                    'UODO (Poland)',
                    'ANSPDCP (Romania)',
                    'AZOP (Croatia)',
                    'DVI (Latvia)',
                    'VDAI (Lithuania)',
                    'CNPD (Portugal)',
                    'IDPC (Malta)',
                    'EDPS (EU)',
                    'ANPD (Brazil)',
                    'HHS OCR (USA)',
                    'PDPC (Singapore)',
                    'PPC (Japan)',
                    'PIPC (South Korea)',
                    'PCPD (Hong Kong)',
                    'NPC (Philippines)',
                    'PDPA (Thailand)',
                    'SDAIA (Saudi Arabia)',
                    'NDPC (Nigeria)',
                    'Information Regulator (South Africa)'
                    ] as $r)
                    <option value="{{ $r }}" {{ ($filters['regulator'] ?? null) === $r ? 'selected' : '' }}>{{ $r }}
                    </option>
                    @endforeach
                </select>

                {{-- SECTOR --}}
                <select name="sector">
                    <option value="">All Sectors</option>
                    @foreach (['Finance & Banking','Healthcare','Technology','Retail &
                    E-commerce','Telecommunications','Public Sector'] as $s)
                    <option value="{{ $s }}">{{ $s }}</option>
                    @endforeach
                </select>

                {{-- YEAR --}}
                <select name="year">
                    <option value="">All Years</option>
                    @for ($y = date('Y'); $y >= 2018; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>

                {{-- VIOLATION TYPE --}}
                <select name="violation_type">
                    <option value="">All Violation Types</option>
                    @foreach (['Security Breach','Inadequate Security','Consent Issues','Transparency','Data
                    Transfer','Children\'s Privacy'] as $v)
                    <option value="{{ $v }}">{{ $v }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</section>

{{-- LATEST FINES --}}
<section class="latest-fines">
    <div class="container">
        <div class="section-header">
            <h2>Latest Enforcement Actions</h2>
            <a href="/database" class="view-all">
                View All <i class="fas fa-chevron-right"></i>
            </a>
        </div>

        <div class="fines-list">
            @if ($latestFines->isEmpty())
            <p class="no-data">No fines found. Add data to your database to see results.</p>
            @else
            @foreach ($latestFines as $fine)
            <div class="fine-card reveal-on-scroll">

                <div class="fine-org">
                    <h3>{{ $fine->organisation }}</h3>
                    <p>{{ $fine->regulator }}</p>
                </div>

                <div class="fine-amount">
                    <div class="amount">
                        {{ $fine->formatted_amount }}
                    </div>
                    <div class="date">
                        {{ \Carbon\Carbon::parse($fine->fine_date)->format('M Y') }}
                    </div>
                </div>

                <div class="fine-type">
                    <span class="badge badge-red">{{ $fine->violation_type }}</span>
                    <div class="law">{{ $fine->law }} {{ $fine->articles_breached }}</div>
                </div>

                <div class="fine-summary">
                    <p>
                        @if (strlen($fine->summary) > 100)
                        {{ substr($fine->summary, 0, 100) }}
                        <a href="{{ route('fine.show', $fine->id) }}" class="more-link">more</a>
                        @else
                        {{ $fine->summary }}
                        @endif
                    </p>
                </div>

                <div class="fine-action">
                    <a href="{{ $fine->link_to_case }}" target="_blank" class="btn btn-primary btn-sm">
                        View Case
                    </a>
                </div>

            </div>
            @endforeach
            @endif
        </div>

    </div>
</section>

{{-- ANALYTICS --}}
<section class="analytics">
    <div class="container">
        <div class="section-header centered">
            <h2>Analytics & Insights</h2>
            <p>Understand global enforcement trends at a glance</p>
        </div>

        <div class="charts-grid">

            {{-- TOP REGULATORS --}}
            <div class="chart-card reveal-on-scroll">
                <h3><i class="fas fa-chart-bar"></i> Top Regulators by Enforcement Actions</h3>

                <div class="chart-bars">
                    @foreach ($regulatorStats as $stat)
                    <div class="bar-item">
                        <div class="bar-label">
                            <span>{{ $stat->regulator }}</span>
                            <span>{{ $stat->count }} cases</span>
                        </div>
                        <div class="bar-bg">
                            <div class="bar-fill" style="width: {{ $stat->percent }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- TOP SECTORS --}}
            <div class="chart-card reveal-on-scroll">
                <h3><i class="fas fa-chart-line"></i> Most Fined Sectors</h3>

                <div class="chart-bars">
                    @foreach ($sectorStats as $stat)
                    <div class="bar-item">
                        <div class="bar-label">
                            <span>{{ $stat->sector }}</span>
                            <span>{{ $stat->count }} cases</span>
                        </div>
                        <div class="bar-bg">
                            <div class="bar-fill bar-fill-purple" style="width: {{ $stat->percent }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>

        <div class="text-center">
            <a href="/dashboards" class="btn btn-primary btn-large">View Full Dashboards</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="container">
        <div class="section-header centered">
            <h2>How It Works</h2>
            <p>Powerful tools for compliance professionals</p>
        </div>

        <div class="features-list">
            <div class="feature-item reveal-on-scroll">
                <div class="feature-icon blue">
                    <i class="fas fa-search"></i>
                </div>
                <div class="feature-content">
                    <h3>Search & Filter</h3>
                    <p>Advanced search across 12,50 0+ enforcement actions with powerful filtering by regulator, sector,
                        date, and violation type</p>
                </div>
            </div>

            <div class="feature-item reveal-on-scroll">
                <div class="feature-icon indigo">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="feature-content">
                    <h3>Dashboards & Reports</h3>
                    <p>Visualize trends, compare regulators, and generate custom reports for stakeholder presentations
                    </p>
                </div>
            </div>

            <div class="feature-item reveal-on-scroll">
                <div class="feature-icon green">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="feature-content">
                    <h3>Alerts & Notifications</h3>
                    <p>Receive instant alerts on new enforcement actions relevant to your industry or jurisdiction</p>
                </div>
            </div>

            <div class="feature-item reveal-on-scroll">
                <div class="feature-icon purple">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="feature-content">
                    <h3>Case Summaries</h3>
                    <p>Detailed summaries with key facts, legal basis, and outcomes to understand enforcement reasoning
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta reveal-on-scroll">
    <div class="container">
        <h2>Stay Ahead of Global Enforcement</h2>
        <p>Join thousands of compliance professionals who trust GlobalFines to stay informed. Sign up for alerts and
            full database access today.</p>
        <div class="cta-buttons">
            <a href="database" class="btn btn-primary">Explore Database</a>
        </div>
    </div>
</section>


<script src="{{ asset('js/main.js') }}"></script>

@endsection