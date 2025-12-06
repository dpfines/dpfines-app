@extends('layout')

@section('content')
<div class="admin-shell">
    @include('admin._sidebar')
    <main class="container-fluid mt-4">
    <div class="page-header mb-4">
        <h1>Submit Scraped Fine for Review</h1>
        <div class="actions">
            <a href="{{ route('admin.scraped-fines.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <strong>Validation Errors:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">Fine Information</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.scraped-fines.store') }}" method="POST" novalidate>
                @csrf

                <div class="alert alert-info">
                    <strong>Note:</strong> This fine will be submitted for review by an administrator before being added to the database.
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="organisation" class="form-label">Organisation Name *</label>
                        <input type="text" class="form-control @error('organisation') is-invalid @enderror"
                               id="organisation" name="organisation"
                               value="{{ old('organisation') }}"
                               required minlength="3">
                        @error('organisation')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="regulator" class="form-label">Regulator</label>
                        <select id="regulator" name="regulator" class="form-select @error('regulator') is-invalid @enderror">
                            <option value="">Select regulator...</option>
                            @foreach([
                                'ICO (UK)','CNIL (France)','BfDI (Germany)','DPC (Ireland)','AEPD (Spain)',
                                'FTC (USA)','OAIC (Australia)','OPC (Canada)','CNPD (Luxembourg)'
                            ] as $r)
                                <option value="{{ $r }}" {{ old('regulator') == $r ? 'selected' : '' }}>{{ $r }}</option>
                            @endforeach
                        </select>
                        @error('regulator')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="fine_amount" class="form-label">Fine Amount *</label>
                        <input type="number" step="0.01" class="form-control @error('fine_amount') is-invalid @enderror"
                               id="fine_amount" name="fine_amount"
                               value="{{ old('fine_amount') }}"
                               required min="0">
                        @error('fine_amount')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="currency" class="form-label">Currency *</label>
                        <select class="form-select @error('currency') is-invalid @enderror"
                                id="currency" name="currency" required>
                            <option value="">Select...</option>
                            @foreach(['EUR', 'USD', 'GBP', 'AUD', 'CAD'] as $curr)
                                <option value="{{ $curr }}" {{ old('currency') === $curr ? 'selected' : '' }}>
                                    {{ $curr }}
                                </option>
                            @endforeach
                        </select>
                        @error('currency')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="fine_date" class="form-label">Fine Date *</label>
                        <input type="date" class="form-control @error('fine_date') is-invalid @enderror"
                               id="fine_date" name="fine_date"
                               value="{{ old('fine_date') }}"
                               required>
                        @error('fine_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="sector" class="form-label">Sector</label>
                        <select id="sector" name="sector" class="form-select @error('sector') is-invalid @enderror">
                            <option value="">Select sector...</option>
                            @foreach([
                                'Finance & Banking','Healthcare','Technology','Retail & E-commerce','Telecommunications',
                                'Public Sector','Education','Aviation / Transportation','Social Media'
                            ] as $s)
                                <option value="{{ $s }}" {{ old('sector') == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('sector')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="region" class="form-label">Region</label>
                        <select id="region" name="region" class="form-select @error('region') is-invalid @enderror">
                            <option value="">Not specified</option>
                            @foreach(['EU / EEA','USA','Australia','Canada','Global'] as $reg)
                                <option value="{{ $reg }}" {{ old('region') == $reg ? 'selected' : '' }}>{{ $reg }}</option>
                            @endforeach
                        </select>
                        @error('region')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="law" class="form-label">Law/Regulation</label>
                    <select id="law" name="law" class="form-select @error('law') is-invalid @enderror">
                        <option value="">Select law...</option>
                        @foreach(['GDPR','UK GDPR','DPA 2018','CCPA','Other'] as $l)
                            <option value="{{ $l }}" {{ old('law') == $l ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                    @error('law')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="articles_breached" class="form-label">Articles Breached</label>
                    <input type="text" class="form-control @error('articles_breached') is-invalid @enderror"
                           id="articles_breached" name="articles_breached"
                           value="{{ old('articles_breached') }}">
                    @error('articles_breached')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="violation_type" class="form-label">Violation Type</label>
                    <select id="violation_type" name="violation_type" class="form-select @error('violation_type') is-invalid @enderror">
                        <option value="">Select type...</option>
                        @foreach([
                            'Security Breach','Inadequate Security','Consent Issues','Transparency',
                            'Data Transfer','Unlawful Processing','Childrens Privacy'
                        ] as $v)
                            <option value="{{ $v }}" {{ old('violation_type') == $v ? 'selected' : '' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                    @error('violation_type')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="summary" class="form-label">Summary *</label>
                    <textarea class="form-control @error('summary') is-invalid @enderror"
                              id="summary" name="summary" rows="5"
                              required minlength="10" maxlength="5000">{{ old('summary') }}</textarea>
                    @error('summary')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="badges" class="form-label">Badges (comma-separated)</label>
                        <input type="text" class="form-control @error('badges') is-invalid @enderror"
                               id="badges" name="badges"
                               value="{{ old('badges') }}"
                               placeholder="e.g., ai,gdpr,privacy">
                        @error('badges')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="link_to_case" class="form-label">Link to Case</label>
                        <input type="url" class="form-control @error('link_to_case') is-invalid @enderror"
                               id="link_to_case" name="link_to_case"
                               value="{{ old('link_to_case') }}">
                        @error('link_to_case')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Submit for Review</button>
                    <a href="{{ route('admin.scraped-fines.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    </main>
</div>
@endsection
