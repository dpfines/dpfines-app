@extends('layout')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

<section class="about-section">
    <div class="container">
        <h1>Cookie Policy</h1>

        <p class="lead-text">Last updated: {{ \Carbon\Carbon::now()->format('F j, Y') }}</p>

        <p>This Cookie Policy explains how DP Fines uses cookies and similar technologies on our website.</p>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>What are cookies?</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <p>Cookies are small text files placed on your device to help websites remember information about your visit — like language preferences or whether you are logged in.</p>
            </div>
        </div>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>How we use cookies</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <ul>
                    <li><strong>Essential cookies:</strong> Required for the website to operate (session management, security).</li>
                    <li><strong>Performance & analytics:</strong> We use analytics cookies to understand how visitors use the site and to help improve it (e.g., page views, navigation paths). This may include third-party analytics providers.</li>
                    <li><strong>Functional cookies:</strong> Remember preferences such as language or UI settings.</li>
                </ul>
            </div>
        </div>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>Third-party cookies</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <p>We include third-party resources (CDNs, analytics). Those providers may set their own cookies; please review their privacy policies for details.</p>
            </div>
        </div>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>Managing cookies</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <p>You can set your browser to block or alert you about cookies, or use privacy extensions to manage them. Blocking cookies may affect certain features of the site.</p>
            </div>
        </div>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>Contact</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <p>If you have questions about our cookie practices, contact us at <a href="mailto:info@dpfines.com">info@dpfines.com</a>.</p>
            </div>
        </div>

    </div>
</section>

@endsection
