@extends('layout')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #4b5563 100%); padding: 20px;">
    <div style="width: 100%; max-width: 420px;">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 32px; color: white;">
            <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 8px;">Create Admin Account</h1>
            <p style="font-size: 14px; opacity: 0.9;">Register an administrator account</p>
        </div>

        <!-- Card -->
        <div style="background: white; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); padding: 40px; margin-bottom: 20px;">
            @if ($errors->any())
                <div style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ url('/admin/register') }}" novalidate>
                @csrf

                <!-- Name -->
                <div style="margin-bottom: 20px;">
                    <label for="name" style="display: block; font-size: 14px; font-weight: 500; color: #1f2937; margin-bottom: 8px;">Full Name</label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="John Doe"
                           style="width: 100%; padding: 10px 12px; font-size: 14px; border: 1px solid {{ $errors->has('name') ? '#dc2626' : '#d1d5db' }}; border-radius: 8px; box-sizing: border-box; font-family: inherit; transition: border-color 0.2s;"
                           required>
                    @if($errors->has('name'))
                        <p style="color: #dc2626; font-size: 12px; margin-top: 4px;">{{ $errors->first('name') }}</p>
                    @endif
                </div>

                <!-- Email -->
                <div style="margin-bottom: 20px;">
                    <label for="email" style="display: block; font-size: 14px; font-weight: 500; color: #1f2937; margin-bottom: 8px;">Email Address</label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="you@example.com"
                           style="width: 100%; padding: 10px 12px; font-size: 14px; border: 1px solid {{ $errors->has('email') ? '#dc2626' : '#d1d5db' }}; border-radius: 8px; box-sizing: border-box; font-family: inherit; transition: border-color 0.2s;"
                           required>
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
                           placeholder="At least 8 characters"
                           style="width: 100%; padding: 10px 12px; font-size: 14px; border: 1px solid {{ $errors->has('password') ? '#dc2626' : '#d1d5db' }}; border-radius: 8px; box-sizing: border-box; font-family: inherit; transition: border-color 0.2s;"
                           required>
                    @if($errors->has('password'))
                        <p style="color: #dc2626; font-size: 12px; margin-top: 4px;">{{ $errors->first('password') }}</p>
                    @else
                        <p style="color: #6b7280; font-size: 12px; margin-top: 4px;">Use uppercase, lowercase, numbers, and symbols</p>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div style="margin-bottom: 24px;">
                    <label for="password_confirmation" style="display: block; font-size: 14px; font-weight: 500; color: #1f2937; margin-bottom: 8px;">Confirm Password</label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           placeholder="Repeat your password"
                           style="width: 100%; padding: 10px 12px; font-size: 14px; border: 1px solid {{ $errors->has('password_confirmation') ? '#dc2626' : '#d1d5db' }}; border-radius: 8px; box-sizing: border-box; font-family: inherit; transition: border-color 0.2s;"
                           required>
                    @if($errors->has('password_confirmation'))
                        <p style="color: #dc2626; font-size: 12px; margin-top: 4px;">{{ $errors->first('password_confirmation') }}</p>
                    @endif
                </div>

                <!-- Submit -->
                <button type="submit" style="width: 100%; padding: 10px 16px; background: linear-gradient(135deg, #3047af 0%, #4b5563 100%); color: white; font-size: 14px; font-weight: 600; border: none; border-radius: 8px; cursor: pointer; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    Create Account
                </button>
            </form>
        </div>

        <!-- Footer -->
        <p style="text-align: center; color: white; font-size: 14px;">
            Already have an account? <a href="{{ url('/admin/login') }}" style="color: #ebebeb; text-decoration: none; font-weight: 600;">Sign in</a>
        </p>
    </div>
</div>
@endsection
