@extends('layout')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #4b5563 100%); padding: 20px;">
    <div style="width: 100%; max-width: 420px;">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 32px; color: white;">
            <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 8px;">Admin Panel</h1>
            <p style="font-size: 14px; opacity: 0.9;">Sign in to your account</p>
        </div>

        <!-- Card -->
        <div style="background: white; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); padding: 40px; margin-bottom: 20px;">
            @if (session('success'))
                <div style="background-color: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ url('/admin/login') }}" novalidate>
                @csrf

                <!-- Email -->
                <div style="margin-bottom: 20px;">
                    <label for="email" style="display: block; font-size: 14px; font-weight: 500; color: #1f2937; margin-bottom: 8px;">Email Address</label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="you@example.com"
                           style="width: 100%; padding: 10px 12px; font-size: 14px; border: 1px solid {{ $errors->has('email') ? '#dc2626' : '#d1d5db' }}; border-radius: 8px; box-sizing: border-box; font-family: inherit; transition: border-color 0.2s;"
                           required
                           autofocus>
                    @if($errors->has('email'))
                        <p style="color: #dc2626; font-size: 12px; margin-top: 4px;">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <!-- Password -->
                <div style="margin-bottom: 20px;">
                    <label for="password" style="display: block; font-size: 14px; font-weight: 500; color: #1f2937; margin-bottom: 8px;">Password</label>
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="Enter your password"
                           style="width: 100%; padding: 10px 12px; font-size: 14px; border: 1px solid {{ $errors->has('password') ? '#dc2626' : '#d1d5db' }}; border-radius: 8px; box-sizing: border-box; font-family: inherit; transition: border-color 0.2s;"
                           required>
                    @if($errors->has('password'))
                        <p style="color: #dc2626; font-size: 12px; margin-top: 4px;">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <!-- Remember & Forgot -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; font-size: 14px;">
                    <label style="display: flex; align-items: center; color: #374151; cursor: pointer;">
                        <input type="checkbox" name="remember" value="1" style="margin-right: 8px; cursor: pointer;">
                        <span>Remember me</span>
                    </label>
                    <a href="/password/reset" style="color: #667eea; text-decoration: none; transition: color 0.2s;">Forgot password?</a>
                </div>

                <!-- Submit -->
                <button type="submit" style="width: 100%; padding: 10px 16px; background: linear-gradient(135deg, #3047af 0%, #4b5563 100%); color: white; font-size: 14px; font-weight: 600; border: none; border-radius: 8px; cursor: pointer; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    Sign In
                </button>
            </form>
        </div>

        <!-- Resend Verification Section -->
        <div style="margin-bottom: 20px;">
            <button type="button" onclick="document.getElementById('resend-form').style.display = document.getElementById('resend-form').style.display === 'none' ? 'block' : 'none';" style="width: 100%; padding: 10px 16px; background: #f3f4f6; color: #374151; font-size: 14px; font-weight: 600; border: 1px solid #d1d5db; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                Didn't receive verification email?
            </button>
            <div id="resend-form" style="display: none; margin-top: 12px; padding: 16px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;">
                <form method="POST" action="{{ route('admin.verification.send') }}">
                    @csrf
                    <p style="font-size: 12px; color: #6b7280; margin-bottom: 12px;">Enter your email to receive a new verification link:</p>
                    <div style="display: flex; gap: 8px;">
                        <input type="email"
                               name="email"
                               placeholder="your@email.com"
                               value="{{ old('email') }}"
                               style="flex: 1; padding: 8px 12px; font-size: 12px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; font-family: inherit;"
                               required>
                        <button type="submit" style="padding: 8px 16px; background: #667eea; color: white; font-size: 12px; font-weight: 600; border: none; border-radius: 6px; cursor: pointer; white-space: nowrap; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            Resend
                        </button>
                    </div>
                    @if($errors->has('email'))
                        <p style="color: #dc2626; font-size: 11px; margin-top: 6px;">{{ $errors->first('email') }}</p>
                    @endif
                </form>
            </div>
        </div>

        <!-- Footer -->
        <p style="text-align: center; color: white; font-size: 14px;">
            New admin? <a href="{{ url('/admin/register') }}" style="color: #ebebeb; text-decoration: none; font-weight: 600;">Create account</a>
        </p>
    </div>
</div>
@endsection
