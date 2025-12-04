<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;
use Carbon\Carbon;

class AdminVerificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that registration sends verification email and doesn't auto-login
     */
    public function test_registration_sends_verification_email_and_no_auto_login(): void
    {
        Notification::fake();

        $response = $this->post('/admin/register', [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'SecurePassword123!',
        ]);

        // User should be created but not logged in
        $this->assertDatabaseHas('users', [
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);

        // Verify email_verified_at is null
        $user = User::where('email', 'admin@example.com')->first();
        $this->assertNull($user->email_verified_at);

        // User should be redirected to login
        $response->assertRedirect('/admin/login');

        // Should not be authenticated
        $this->assertFalse(auth()->check());
    }

    /**
     * Test that login is blocked for unverified email
     */
    public function test_login_blocked_for_unverified_email(): void
    {
        $user = User::factory()->create([
            'email' => 'unverified@example.com',
            'password' => bcrypt('SecurePassword123!'),
            'is_admin' => true,
            'email_verified_at' => null,
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'unverified@example.com',
            'password' => 'SecurePassword123!',
        ]);

        // Should be redirected back with error
        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString('verify', strtolower($response->getSession()->get('errors')->first('email')));

        // Should not be authenticated
        $this->assertFalse(auth()->check());
    }

    /**
     * Test that login succeeds with verified email
     */
    public function test_login_succeeds_with_verified_email(): void
    {
        $user = User::factory()->create([
            'email' => 'verified@example.com',
            'password' => bcrypt('SecurePassword123!'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'verified@example.com',
            'password' => 'SecurePassword123!',
        ]);

        // Should be redirected to dashboard
        $response->assertRedirect('/admin/dashboard');

        // Should be authenticated
        $this->assertTrue(auth()->check());
        $this->assertEquals($user->id, auth()->id());
    }

    /**
     * Test email verification via signed URL
     */
    public function test_email_verification_via_signed_url(): void
    {
        $user = User::factory()->create([
            'email' => 'verify@example.com',
            'is_admin' => true,
            'email_verified_at' => null,
        ]);

        $hash = sha1($user->email);
        $signedUrl = URL::temporarySignedRoute(
            'admin.verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => $hash]
        );

        // Visit the verification link
        $response = $this->get($signedUrl);

        // Should be redirected to login with success message
        $response->assertRedirect('/admin/login');
        $this->assertNotNull(session('success'));

        // Verify the user's email is now verified
        $user->refresh();
        $this->assertNotNull($user->email_verified_at);
    }

    /**
     * Test that already verified email cannot be verified again
     */
    public function test_already_verified_email_shows_message(): void
    {
        $user = User::factory()->create([
            'email' => 'already@example.com',
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $hash = sha1($user->email);
        $signedUrl = URL::temporarySignedRoute(
            'admin.verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => $hash]
        );

        $response = $this->get($signedUrl);

        // Should be redirected to login
        $response->assertRedirect('/admin/login');
        $this->assertNotNull(session('success'));
    }

    /**
     * Test invalid signature on verification link
     */
    public function test_invalid_signature_aborts(): void
    {
        $user = User::factory()->create([
            'email' => 'invalid@example.com',
            'is_admin' => true,
            'email_verified_at' => null,
        ]);

        // Try to access with tampered URL (no valid signature)
        $response = $this->get("/admin/verify-email/{$user->id}/fakehash");

        // Should abort with 403
        $response->assertStatus(403);
    }

    /**
     * Test incorrect hash on valid signature
     */
    public function test_incorrect_hash_aborts(): void
    {
        $user = User::factory()->create([
            'email' => 'hash@example.com',
            'is_admin' => true,
            'email_verified_at' => null,
        ]);

        // Create valid signature but with wrong hash
        $wrongHash = sha1('different@email.com');
        $signedUrl = URL::temporarySignedRoute(
            'admin.verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => $wrongHash]
        );

        $response = $this->get($signedUrl);

        // Should abort with 403
        $response->assertStatus(403);
    }

    /**
     * Test resend verification email
     */
    public function test_resend_verification_email(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'resend@example.com',
            'is_admin' => true,
            'email_verified_at' => null,
        ]);

        $response = $this->post('/admin/email/verification-notification', [
            'email' => 'resend@example.com',
        ]);

        // Should be redirected back with success
        $response->assertSessionHas('success');

        // Verify the user's verification status hasn't changed
        $user->refresh();
        $this->assertNull($user->email_verified_at);
    }

    /**
     * Test resend verification for non-existent user
     */
    public function test_resend_verification_nonexistent_user(): void
    {
        $response = $this->post('/admin/email/verification-notification', [
            'email' => 'nonexistent@example.com',
        ]);

        // Should have error
        $response->assertSessionHasErrors('email');
    }

    /**
     * Test resend verification for already verified user
     */
    public function test_resend_verification_already_verified(): void
    {
        $user = User::factory()->create([
            'email' => 'already@verified.com',
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $response = $this->post('/admin/email/verification-notification', [
            'email' => 'already@verified.com',
        ]);

        // Should show success message
        $response->assertSessionHas('success');
    }

    /**
     * Test throttling on resend verification
     */
    public function test_resend_verification_throttled(): void
    {
        $user = User::factory()->create([
            'email' => 'throttle@example.com',
            'is_admin' => true,
            'email_verified_at' => null,
        ]);

        // Make 6 requests rapidly
        for ($i = 0; $i < 6; $i++) {
            $this->post('/admin/email/verification-notification', [
                'email' => 'throttle@example.com',
            ]);
        }

        // 7th request should be throttled
        $response = $this->post('/admin/email/verification-notification', [
            'email' => 'throttle@example.com',
        ]);

        $response->assertStatus(429);
    }
}
