<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Store a newsletter subscription
     */
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'frequency' => 'sometimes|in:weekly,monthly',
            'preferred_sectors' => 'sometimes|array',
            'preferred_regulators' => 'sometimes|array',
        ]);

        // Check if email already exists
        $existingSubscriber = NewsletterSubscriber::where('email', $validated['email'])->first();

        if ($existingSubscriber) {
            // If subscriber is already active, return 409 Conflict
            if ($existingSubscriber->is_active) {
                return response()->json([
                    'message' => 'This email is already subscribed to our newsletter.',
                    'subscriber' => $existingSubscriber,
                ], 409);
            }

            // If subscriber was unsubscribed, re-activate them
            $validated['frequency'] = $validated['frequency'] ?? 'weekly';
            $existingSubscriber->update([
                'is_active' => true,
                'frequency' => $validated['frequency'],
                'preferred_sectors' => $validated['preferred_sectors'] ?? null,
                'preferred_regulators' => $validated['preferred_regulators'] ?? null,
            ]);

            return response()->json([
                'message' => 'Welcome back! You\'ve been re-subscribed to our newsletter.',
                'subscriber' => $existingSubscriber,
            ], 200);
        }

        // Create new subscriber
        $validated['frequency'] = $validated['frequency'] ?? 'weekly';
        $subscriber = NewsletterSubscriber::create($validated);

        return response()->json([
            'message' => 'Successfully subscribed to newsletter!',
            'subscriber' => $subscriber,
        ], 201);
    }

    /**
     * Unsubscribe from newsletter
     */
    public function unsubscribe($token)
    {
        $subscriber = NewsletterSubscriber::where('unsubscribe_token', $token)->firstOrFail();
        $subscriber->update(['is_active' => false]);

        return view('newsletter.unsubscribed');
    }

    /**
     * Update subscription preferences
     */
    public function updatePreferences(Request $request, $token)
    {
        $subscriber = NewsletterSubscriber::where('unsubscribe_token', $token)->firstOrFail();

        $validated = $request->validate([
            'frequency' => 'required|in:weekly,monthly',
            'preferred_sectors' => 'sometimes|array',
            'preferred_regulators' => 'sometimes|array',
        ]);

        $subscriber->update($validated);

        return response()->json([
            'message' => 'Preferences updated successfully!',
            'subscriber' => $subscriber,
        ]);
    }
}
