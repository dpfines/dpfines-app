<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'frequency',
        'preferred_sectors',
        'preferred_regulators',
        'is_active',
        'unsubscribe_token',
    ];

    protected $casts = [
        'preferred_sectors' => 'array',
        'preferred_regulators' => 'array',
        'is_active' => 'boolean',
        'last_sent_at' => 'datetime',
    ];

    /**
     * Boot method to generate unsubscribe token
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->unsubscribe_token) {
                $model->unsubscribe_token = Str::random(64);
            }
        });
    }

    /**
     * Get subscribers that should receive emails
     */
    public static function getSubscribersToNotify($frequency = 'weekly')
    {
        return self::where('is_active', true)
            ->where('frequency', $frequency)
            ->get();
    }

    /**
     * Check if subscriber should receive notification based on filters
     */
    public function shouldReceiveNotification($fine)
    {
        // If no preferences, send to everyone
        if (empty($this->preferred_sectors) && empty($this->preferred_regulators)) {
            return true;
        }

        // Check sector preference
        if (!empty($this->preferred_sectors) && in_array($fine->sector, $this->preferred_sectors)) {
            return true;
        }

        // Check regulator preference
        if (!empty($this->preferred_regulators) && in_array($fine->regulator, $this->preferred_regulators)) {
            return true;
        }

        return false;
    }
}
