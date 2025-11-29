@extends('layout')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

<section class="about-section">
    <div class="container">
        <h1>Terms of Service</h1>

        <p class="lead-text">Last updated: {{ \Carbon\Carbon::now()->format('F j, Y') }}</p>

        <p>Welcome to DP Fines. By using this website you agree to the following terms. Please read them carefully.</p>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>Use of Site</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <p>The content on this site is provided for informational purposes only. We strive for accuracy but do not guarantee completeness or timeliness of data. Use the information at your own discretion.</p>
            </div>
        </div>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>User Contributions</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <p>If you submit information (corrections, contributions or comments), you grant DP Fines a non-exclusive, royalty-free, worldwide license to use, reproduce, and publish that content as part of the service.</p>
            </div>
        </div>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>Prohibited Conduct</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <p>You agree not to misuse the site or attempt to access data or services in an unauthorized manner. Automated scraping or bulk downloads that negatively impact the service are prohibited unless expressly permitted.</p>
            </div>
        </div>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>Disclaimer & Limitation of Liability</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <p>THE SITE IS PROVIDED "AS IS" WITHOUT WARRANTIES OF ANY KIND. DP FINES IS NOT LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, OR CONSEQUENTIAL DAMAGES ARISING FROM YOUR USE OF THE SITE.</p>
            </div>
        </div>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>Governing Law</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <p>These terms are governed by the laws of the jurisdiction in which DP Fines operates. If any provision is found unenforceable, the remaining provisions will continue in effect.</p>
            </div>
        </div>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>Contact</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <p>Questions about these terms should be directed to <a href="mailto:info@dpfines.com">info@dpfines.com</a>.</p>
            </div>
        </div>

    </div>
</section>

@endsection
