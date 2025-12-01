@extends('layout')

@section('content')

<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="hero">
    <div class="container">
        <h1>Global Fines Database</h1>
        <p>Browse all enforcement actions from regulators around the world</p>
    </div>
</div>

{{-- SEARCH + FILTERS --}}
<section class="search-section">
    <div class="container">
        <form action="/database" method="GET" class="search-form">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Search by organisation, sector, law, or summary..."
                    value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>

            <div class="filters">
                {{-- REGULATOR - FULL LIST --}}
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
                    E-commerce','Telecommunications','Public Sector','Education','Aviation / Transportation','Social
                    Media'] as $s)
                    <option value="{{ $s }}" {{ ($filters['sector'] ?? null) === $s ? 'selected' : '' }}>{{ $s }}
                    </option>
                    @endforeach
                </select>

                {{-- YEAR --}}
                <select name="year">
                    <option value="">All Years</option>
                    @for ($y = date('Y'); $y >= 2018; $y--)
                    <option value="{{ $y }}" {{ ($filters['year'] ?? null) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>

                {{-- VIOLATION TYPE --}}
                <select name="violation_type">
                    <option value="">All Violation Types</option>
                    @foreach (['Security Breach','Inadequate Security','Consent Issues','Transparency','Data
                    Transfer','Unlawful Processing','Childrens Privacy'] as $v)
                    <option value="{{ $v }}" {{ ($filters['violation_type'] ?? null) === $v ? 'selected' : '' }}>
                        {{ $v }}
                    </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</section>

{{-- ALL FINES --}}
<section class="database-section">
    <div class="container">
        <div class="section-header">
            <h2>All Enforcement Actions</h2>
            <p class="result-count">
                @if ($fines->total() > 0)
                Showing {{ $fines->count() }} of {{ $fines->total() }} enforcement actions
                @else
                No enforcement actions found
                @endif
            </p>
        </div>

        <div class="fines-list">
            @if ($fines->isEmpty())
            <div class="no-data">
                <i class="fas fa-info-circle"></i>
                <p>No enforcement actions found matching your filters. Try adjusting your search criteria.</p>
            </div>
            @else
            @foreach ($fines as $fine)
            <div class="fine-card">

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

        {{-- PAGINATION --}}
        @if ($fines->hasPages())
        <div class="pagination-wrapper">
            {{ $fines->links() }}
        </div>
        @endif
    </div>
</section>

@endsection