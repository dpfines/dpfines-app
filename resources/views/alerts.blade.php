@extends('layout')

@section('content')

<section class="about-section">
    <div class="container">
        <h1>Sign Up for Alerts</h1>
        <p class="lead-text">Get weekly or monthly updates about new enforcement actions</p>

        <div style="max-width: 600px; margin: 3rem auto;">
            <div style="background: #f9fafb; padding: 2rem; border-radius: 8px; border: 1px solid #e5e7eb;">
                <h2 style="margin-top: 0; color: #1e3a8a;">Subscribe to DP Fines Alerts</h2>
                <p style="color: #666;">Never miss important enforcement actions. Get notified about new fines that matter to your organization.</p>

                <form id="newsletter-form" method="POST" action="{{ route('newsletter.subscribe') }}">
                    @csrf

                    <div style="margin-bottom: 1.5rem;">
                        <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Email Address *</label>
                        <input type="email" id="email" name="email" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; box-sizing: border-box;"
                            placeholder="your@email.com">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label for="frequency" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Update Frequency *</label>
                        <select id="frequency" name="frequency" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; box-sizing: border-box;">
                            <option value="weekly">Weekly (Every Monday)</option>
                            <option value="monthly">Monthly (1st of the month)</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 1rem; font-weight: 600; color: #333;">Filter by Sector (Optional)</label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                            @foreach(['Finance & Banking', 'Healthcare', 'Technology', 'Retail & E-commerce', 'Telecommunications', 'Public Sector'] as $sector)
                            <label style="display: flex; align-items: center; cursor: pointer;">
                                <input type="checkbox" name="preferred_sectors[]" value="{{ $sector }}"
                                    style="margin-right: 0.5rem; width: 18px; height: 18px; cursor: pointer;">
                                <span>{{ $sector }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; margin-bottom: 1rem; font-weight: 600; color: #333;">Filter by Regulator (Optional)</label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                            @foreach(['ICO (UK)', 'CNIL (France)', 'DPC (Ireland)', 'BfDI (Germany)', 'AEPD (Spain)', 'FTC (USA)', 'OAIC (Australia)', 'OPC (Canada)'] as $regulator)
                            <label style="display: flex; align-items: center; cursor: pointer;">
                                <input type="checkbox" name="preferred_regulators[]" value="{{ $regulator }}"
                                    style="margin-right: 0.5rem; width: 18px; height: 18px; cursor: pointer;">
                                <span>{{ $regulator }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div style="margin-bottom: 1.5rem; padding: 1rem; background: #eff6ff; border-radius: 6px; font-size: 14px; color: #1e3a8a;">
                        <i class="fas fa-info-circle"></i> Leave sector and regulator fields empty to receive updates about all fines.
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 1rem; cursor: pointer;">
                        <i class="fas fa-bell"></i> Subscribe to Alerts
                    </button>

                    <p style="text-align: center; margin-top: 1rem; font-size: 12px; color: #666;">
                        We respect your privacy. <a href="/privacy" style="color: #2563eb;">Learn more</a>
                    </p>
                </form>

                <div id="success-message" style="display: none; margin-top: 1.5rem; padding: 1rem; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px; color: #166534;">
                    <i class="fas fa-check-circle"></i> <strong>Success!</strong> Check your email to confirm your subscription.
                </div>

                <div id="error-message" style="display: none; margin-top: 1.5rem; padding: 1rem; background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; color: #991b1b;">
                    <i class="fas fa-exclamation-circle"></i> <span id="error-text"></span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('newsletter-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    const sectors = Array.from(document.querySelectorAll('input[name="preferred_sectors[]"]:checked')).map(cb => cb.value);
    const regulators = Array.from(document.querySelectorAll('input[name="preferred_regulators[]"]:checked')).map(cb => cb.value);

    const data = {
        email: formData.get('email'),
        frequency: formData.get('frequency'),
    };

    if (sectors.length > 0) {
        data.preferred_sectors = sectors;
    }
    if (regulators.length > 0) {
        data.preferred_regulators = regulators;
    }

    try {
        const response = await fetch('{{ route('newsletter.subscribe') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();

        // Success responses (201 Created or 200 OK)
        if (response.ok) {
            document.getElementById('success-message').style.display = 'block';
            document.getElementById('error-message').style.display = 'none';
            form.reset();
            setTimeout(() => {
                document.getElementById('success-message').style.display = 'none';
            }, 5000);
        }
        // 409 Conflict - Already subscribed
        else if (response.status === 409) {
            document.getElementById('error-text').innerHTML = '<strong>Already Subscribed:</strong> This email is already on our newsletter. Check your inbox for updates!';
            document.getElementById('error-message').style.display = 'block';
            document.getElementById('success-message').style.display = 'none';
        }
        // Other errors
        else {
            const errorText = result.message || result.errors?.email?.[0] || 'An error occurred. Please try again.';
            document.getElementById('error-text').textContent = errorText;
            document.getElementById('error-message').style.display = 'block';
            document.getElementById('success-message').style.display = 'none';
        }
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('error-text').textContent = 'Network error. Please check your connection and try again.';
        document.getElementById('error-message').style.display = 'block';
        document.getElementById('success-message').style.display = 'none';
    }
});
</script>

@endsection
