@extends('layout')

@section('content')

<section class="about-section">
    <div class="container">
        <h1>Unsubscribed</h1>

        <div style="max-width: 600px; margin: 2rem auto; text-align: center; padding: 2rem; background: #f0fdf4; border-radius: 8px; border: 1px solid #bbf7d0;">
            <i class="fas fa-check-circle" style="font-size: 48px; color: #16a34a; margin-bottom: 1rem;"></i>
            <h2 style="color: #166534; margin-bottom: 1rem;">You've been unsubscribed</h2>
            <p style="color: #4b5563; margin-bottom: 1.5rem;">
                Your email has been removed from our newsletter. You will no longer receive weekly or monthly enforcement updates.
            </p>

            <div style="margin: 2rem 0;">
                <p style="color: #666; margin-bottom: 1rem;">Change your mind?</p>
                <a href="/#newsletter" class="btn btn-primary" style="display: inline-block; padding: 10px 20px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px;">
                    Subscribe Again
                </a>
            </div>

            <p style="color: #999; font-size: 14px; margin-top: 2rem;">
                If you have any questions, please <a href="mailto:info@dpfines.com" style="color: #2563eb;">contact us</a>.
            </p>
        </div>
    </div>
</section>

@endsection
