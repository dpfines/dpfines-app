<?php

namespace App\Console\Commands;

use App\Mail\WeeklyFinesNotification;
use App\Models\GlobalFine;
use App\Models\NewsletterSubscriber;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendNewsletterEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send {--frequency=weekly : weekly or monthly}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send newsletter emails to subscribers with new fines';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $frequency = $this->option('frequency');
        $this->info("Sending {$frequency} newsletter emails...");

        // Get all active subscribers with this frequency
        $subscribers = NewsletterSubscriber::where('is_active', true)
            ->where('frequency', $frequency)
            ->get();

        if ($subscribers->isEmpty()) {
            $this->warn('No active subscribers found');
            return;
        }

        $this->info("Found " . count($subscribers) . " subscribers");

        // Calculate date range (weekly = last 7 days, monthly = last 30 days)
        $days = ($frequency === 'monthly') ? 30 : 7;
        $startDate = Carbon::now()->subDays($days);

        $sentCount = 0;
        $failedCount = 0;

        foreach ($subscribers as $subscriber) {
            try {
                // Get new fines since last sent or in the period
                $query = GlobalFine::where('created_at', '>=', $startDate);

                // Apply sector filter if set
                if (!empty($subscriber->preferred_sectors)) {
                    $query->whereIn('sector', $subscriber->preferred_sectors);
                }

                // Apply regulator filter if set
                if (!empty($subscriber->preferred_regulators)) {
                    $query->whereIn('regulator', $subscriber->preferred_regulators);
                }

                $fines = $query->orderBy('fine_date', 'desc')->take(10)->get();

                // Only send if there are new fines
                if ($fines->count() > 0) {
                    Mail::send(new WeeklyFinesNotification($fines, $subscriber));
                    $subscriber->update(['last_sent_at' => now()]);
                    $sentCount++;
                    $this->line("✓ Email sent to {$subscriber->email}");
                } else {
                    $this->line("⊘ No new fines for {$subscriber->email}");
                }
            } catch (\Exception $e) {
                $failedCount++;
                $this->error("✗ Failed to send email to {$subscriber->email}: " . $e->getMessage());
            }
        }

        $this->info("\n=== Summary ===");
        $this->info("Emails sent: {$sentCount}");
        $this->info("Failed: {$failedCount}");
    }
}
