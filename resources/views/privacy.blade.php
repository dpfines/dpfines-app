@extends('layout')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

<section class="about-section">
    <div class="container">
        <h1>Privacy Policy</h1>

        <p class="lead-text">Last updated: {{ \Carbon\Carbon::now()->format('F j, Y') }}</p>

        <p>DP Fines ("we", "our", "us") operates the dpfines_app website, an open-source platform that publishes and aggregates public information about data protection enforcement actions worldwide. This Privacy Policy explains what information we collect, how we use it, and the choices you have.</p>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>Information We Collect</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <ul>
                    <li><strong>Public data and content:</strong> The core content of our site is public enforcement data (fines, summaries, regulator names) collected from public sources. This content is published for informational purposes.</li>
                    <li><strong>User contributions:</strong> If you submit corrections or contribute data via forms or GitHub, we store the content you provide (name, email, submission) so maintainers can review and process it.</li>
                    <li><strong>Contact & newsletter:</strong> When you sign up for our newsletter or contact us, we collect your email and any message you provide.</li>
                    <li><strong>Automatically-collected data:</strong> We collect non-personal usage information such as IP address, browser type, pages visited, and timestamps for analytics and site improvement.</li>
                </ul>
            </div>
        </div>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>How We Use Information</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <ul>
                    <li>To operate, maintain and improve the website and its content.</li>
                    <li>To communicate with contributors and newsletter subscribers.</li>
                    <li>To detect and prevent abuse, spam, or security incidents.</li>
                    <li>To comply with legal obligations or respond to lawful requests.</li>
                </ul>
            </div>
        </div>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>Third-Party Services</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <p>We may use third-party services (CDNs, analytics providers, hosting and GitHub) that collect information to provide their services. Examples include Cloudflare, Google CDN, and analytics tools. These providers have their own privacy policies.</p>
            </div>
        </div>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>Cookies</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <p>We use cookies to improve the user experience, remember optional preferences, and support analytics. For details, see our <a href="/cookies">Cookie Policy</a>.</p>
            </div>
        </div>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>Sharing & Disclosure</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <p>We do not sell personal information. We may disclose information to comply with legal processes or to protect the rights and safety of the site, users, or the public.</p>
            </div>
        </div>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>Your Choices</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <p>You can opt out of our newsletter at any time using the unsubscribe link included in emails. You may also contact us at <a href="mailto:info@dpfines.com">info@dpfines.com</a> to request removal of personal contact information you submitted.</p>
            </div>
        </div>

        <div class="policy-section">
            <div class="policy-section-header">
                <h2>Contact</h2>
                <button class="policy-toggle" aria-label="Toggle section"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="policy-section-body">
                <p>If you have questions about this policy, contact us at <a href="mailto:info@dpfines.com">info@dpfines.com</a>.</p>
            </div>
        </div>

    </div>
</section>

@endsection
