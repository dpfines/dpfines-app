<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Notifications\AdminVerifyEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect('/admin/dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required|string|min:8',
        ]);

        // Attempt authentication
        if (!Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ])->onlyInput('email');
        }

        // Prevent login if email not verified
        if (is_null(Auth::user()->email_verified_at)) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Please verify your email address before logging in. Check your inbox for the verification link.',
            ])->onlyInput('email');
        }

        // Check if user is admin
        if (!Auth::user()->isAdmin()) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Access denied. Admin account required.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect('/admin/dashboard')->with('success', 'Successfully logged in.');
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        // Only allow registration if no admins exist (first admin setup)
        $adminCount = User::admins()->count();

        if ($adminCount > 0 && !Auth::check()) {
            abort(403, 'Registration is closed.');
        }

        return view('admin.auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        // Only allow registration if no admins exist
        if (User::admins()->count() > 0 && !Auth::check()) {
            abort(403, 'Registration is closed.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => true, // First admin or registration by existing admin
        ]);

        // Send email verification link and do not log the user in until verified
        $signedUrl = URL::temporarySignedRoute(
            'admin.verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->getEmailForVerification())
            ]
        );

        Notification::route('mail', $user->email)->notify(new AdminVerifyEmail($signedUrl));

        return redirect('/admin/login')->with('success', 'Account created. Please check your email for a verification link before logging in.');
    }

    /**
     * Verify the admin email from signed link
     */
    public function verifyEmail(Request $request, $id, $hash)
    {
        // Ensure the signed URL is valid
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid or expired verification link.');
        }

        $user = User::findOrFail($id);

        if (sha1($user->getEmailForVerification()) !== $hash) {
            abort(403, 'Verification data does not match.');
        }


        if (! is_null($user->email_verified_at)) {
            return redirect('/admin/login')->with('success', 'Email already verified. You may log in.');
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        return redirect('/admin/login')->with('success', 'Email verified successfully. You may now log in.');
    }

    /**
     * Resend verification email
     */
    public function resendVerification(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->input('email'))->first();

        if (! $user) {
            return back()->withErrors(['email' => 'No account found for that email.']);
        }

        if (! is_null($user->email_verified_at)) {
            return back()->with('success', 'Email already verified. You may log in.');
        }

        $signedUrl = URL::temporarySignedRoute(
            'admin.verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->getEmailForVerification())
            ]
        );

        Notification::route('mail', $user->email)->notify(new AdminVerifyEmail($signedUrl));

        return back()->with('success', 'Verification link resent. Check your email.');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
