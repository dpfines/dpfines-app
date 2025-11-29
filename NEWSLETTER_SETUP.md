# Email Notification System - Implementation Guide

## Overview

The DP Fines app now has a complete email notification system that allows users to subscribe to weekly or monthly updates about new enforcement actions.

## Database

### Newsletter Subscribers Table
- **Table:** `newsletter_subscribers`
- **Columns:**
  - `id` - Primary key
  - `email` - User email (unique)
  - `frequency` - 'weekly' or 'monthly'
  - `preferred_sectors` - JSON array (optional sector filters)
  - `preferred_regulators` - JSON array (optional regulator filters)
  - `is_active` - Boolean (true = subscribed, false = unsubscribed)
  - `last_sent_at` - Timestamp of last email sent
  - `unsubscribe_token` - Unique token for unsubscribe links
  - `created_at`, `updated_at` - Timestamps

## Files Created/Modified

### Models
- **`app/Models/NewsletterSubscriber.php`** - Model for managing subscriptions

### Controllers
- **`app/Http/Controllers/NewsletterController.php`** - Handles subscription logic
  - `subscribe()` - Store new subscription
  - `unsubscribe()` - Deactivate subscription
  - `updatePreferences()` - Update subscriber preferences

### Commands
- **`app/Console/Commands/SendNewsletterEmails.php`** - Scheduled command
  - Sends weekly emails every Monday at 9 AM
  - Sends monthly emails on 1st of month at 9 AM
  - Filters fines based on subscriber preferences

### Migrations
- **`database/migrations/2024_11_29_create_newsletter_subscribers_table.php`**

### Views
- **`resources/views/alerts.blade.php`** - Signup form page
- **`resources/views/newsletter/unsubscribed.blade.php`** - Unsubscribe confirmation
- **`resources/views/emails/weekly-fines-notification.blade.php`** - Email template

### Routes
- `POST /newsletter/subscribe` - Subscribe to newsletter
- `GET /newsletter/unsubscribe/{token}` - Unsubscribe from newsletter
- `POST /newsletter/preferences/{token}` - Update preferences
- `GET /alerts` - Signup page

### Scheduler
- **`app/Console/Kernel.php`** - Configures scheduled tasks

## Setup Instructions

### 1. Run Migration
```bash
php artisan migrate
```

### 2. Configure Mail
Update `.env` with your email provider settings:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=info@dpfines.com
MAIL_FROM_NAME="DP Fines"
```

### 3. Test Sending Emails Manually
```bash
# Send weekly newsletters
php artisan newsletter:send --frequency=weekly

# Send monthly newsletters
php artisan newsletter:send --frequency=monthly
```

### 4. Set Up Scheduler (Production)
Add this to your server's crontab:
```bash
* * * * * cd /path/to/dpfines_app && php artisan schedule:run >> /dev/null 2>&1
```

This runs Laravel's scheduler every minute, which executes:
- **Weekly emails:** Every Monday at 9:00 AM
- **Monthly emails:** 1st of month at 9:00 AM

## Features

### User Features
1. **Email Subscription**
   - User enters email
   - Selects frequency (weekly/monthly)
   - Optionally filters by sector/regulator
   - Form: `/alerts`

2. **Email Content**
   - Shows up to 10 newest fines
   - Displays fine details (amount, date, violation type)
   - Links to full case details
   - Personalized based on user filters

3. **Unsubscribe**
   - Unsubscribe link in every email
   - One-click unsubscribe (no confirmation needed)
   - Token-based (no login required)

4. **Preference Management**
   - Can update frequency and filters
   - Uses same token-based system

### Admin Features
1. **Manual Sending**
   - Run command to send emails anytime
   - Useful for testing or manual campaigns

2. **Subscriber List**
   - Query database for subscriber stats
   - Monitor active subscribers
   - Track last sent times

## API Endpoints

### Subscribe
```
POST /newsletter/subscribe

Body:
{
  "email": "user@example.com",
  "frequency": "weekly",
  "preferred_sectors": ["Finance & Banking", "Healthcare"],
  "preferred_regulators": ["ICO (UK)", "CNIL (France)"]
}

Response:
{
  "message": "Successfully subscribed to newsletter!",
  "subscriber": { ... }
}
```

### Unsubscribe
```
GET /newsletter/unsubscribe/{token}

Response: Redirects to unsubscribe confirmation page
```

### Update Preferences
```
POST /newsletter/preferences/{token}

Body:
{
  "frequency": "monthly",
  "preferred_sectors": ["Technology"],
  "preferred_regulators": []
}

Response:
{
  "message": "Preferences updated successfully!",
  "subscriber": { ... }
}
```

## Database Queries

### Get Active Subscribers
```php
$subscribers = NewsletterSubscriber::where('is_active', true)->get();
```

### Get Weekly Subscribers
```php
$weeklySubscribers = NewsletterSubscriber::where('is_active', true)
    ->where('frequency', 'weekly')
    ->get();
```

### Check Subscription Status
```php
$subscriber = NewsletterSubscriber::where('email', 'user@example.com')->first();
if ($subscriber && $subscriber->is_active) {
    // User is subscribed
}
```

## Email Template Customization

The email template is in `resources/views/emails/weekly-fines-notification.blade.php`. You can customize:
- Email subject line
- Header/footer text
- Fine card styling
- Call-to-action buttons
- Unsubscribe link

## Scheduling in Development

To test the scheduler in development without waiting for cron:
```bash
php artisan schedule:work
```

This starts a background process that runs scheduled tasks every minute.

## Troubleshooting

### Emails Not Sending
1. Check mail configuration in `.env`
2. Test with: `php artisan mail:send`
3. Check Laravel logs in `storage/logs/`

### Scheduler Not Running
1. Verify cron is installed: `crontab -l`
2. Test scheduler: `php artisan schedule:run`
3. Check Laravel logs for errors

### No Subscribers Getting Emails
1. Verify subscribers exist: `php artisan tinker`
   ```php
   App\Models\NewsletterSubscriber::count()
   ```
2. Check if they're active: 
   ```php
   App\Models\NewsletterSubscriber::where('is_active', true)->count()
   ```
3. Verify new fines exist in database

## Future Enhancements

1. **Email Confirmation** - Send confirmation email before subscribing
2. **Preference Panel** - User dashboard to manage subscriptions
3. **Analytics** - Track open rates, click rates
4. **Advanced Filters** - Filter by fine amount, regulation, articles breached
5. **Digest Formatting** - HTML vs plain text options
6. **Time Zone Support** - Send emails at user's local time

---

**Created:** November 29, 2024
**App:** DP Fines
**Version:** 1.0
