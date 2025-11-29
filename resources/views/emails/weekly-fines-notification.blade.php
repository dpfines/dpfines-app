<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
        }
        .header {
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: #1e3a8a;
            font-size: 28px;
        }
        .fine-card {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f9fafb;
        }
        .fine-card h3 {
            margin: 0 0 10px 0;
            color: #1e3a8a;
            font-size: 18px;
        }
        .fine-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 15px;
            font-size: 14px;
            color: #666;
        }
        .fine-amount {
            font-size: 24px;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 10px;
        }
        .fine-summary {
            color: #555;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .badge {
            display: inline-block;
            background-color: #fee2e2;
            color: #991b1b;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .btn {
            display: inline-block;
            background-color: #2563eb;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.2s;
        }
        .btn:hover {
            background-color: #1d4ed8;
        }
        .footer {
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
            margin-top: 30px;
            font-size: 12px;
            color: #999;
            text-align: center;
        }
        .footer a {
            color: #2563eb;
            text-decoration: none;
        }
        .cta-section {
            background-color: #eff6ff;
            padding: 20px;
            border-radius: 6px;
            text-align: center;
            margin: 30px 0;
        }
        .cta-section a {
            background-color: #2563eb;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 DP Fines Weekly Update</h1>
            <p style="margin: 10px 0 0 0; color: #666;">New enforcement actions in your areas of interest</p>
        </div>

        <p>Hi {{ $subscriber->email }},</p>

        <p>We found <strong>{{ count($fines) }} new enforcement action(s)</strong> this week that match your interests. Here's what you need to know:</p>

        <!-- Fine Cards -->
        @foreach($fines as $fine)
        <div class="fine-card">
            <h3>{{ $fine->organisation }}</h3>

            <div class="fine-meta">
                <div><strong>Regulator:</strong> {{ $fine->regulator }}</div>
                <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($fine->fine_date)->format('M d, Y') }}</div>
                <div><strong>Sector:</strong> {{ $fine->sector }}</div>
                <div><strong>Jurisdiction:</strong> {{ $fine->jurisdiction }}</div>
            </div>

            <div class="fine-amount">{{ $fine->formatted_amount }}</div>

            <div class="badge">{{ $fine->violation_type }}</div>

            <div class="fine-summary">
                <strong>Summary:</strong><br>
                {{ substr($fine->summary, 0, 150) }}@if(strlen($fine->summary) > 150)...@endif
            </div>

            <p style="margin: 10px 0 0 0;">
                <strong>Regulation:</strong> {{ $fine->law }} {{ $fine->articles_breached }}
            </p>

            <a href="{{ route('fine.show', $fine->id) }}" class="btn">View Full Case Details</a>
        </div>
        @endforeach

        <!-- CTA Section -->
        <div class="cta-section">
            <h2 style="margin: 0; color: #1e3a8a;">Explore More Fines</h2>
            <p style="margin: 10px 0 0 0; color: #666;">Access our complete database with powerful filters and analytics.</p>
            <a href="{{ url('/database') }}" style="background-color: #2563eb; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; display: inline-block; margin-top: 10px;">View Full Database</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0 0 10px 0;">
                You're receiving this email because you subscribed to DP Fines {{ $subscriber->frequency }} updates.
            </p>
            <p style="margin: 0;">
                <a href="{{ $unsubscribeUrl }}">Unsubscribe</a> |
                <a href="{{ url('/privacy') }}">Privacy Policy</a> |
                <a href="mailto:info@dpfines.com">Contact Us</a>
            </p>
            <p style="margin: 10px 0 0 0; color: #ccc;">
                © {{ date('Y') }} DP Fines. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
