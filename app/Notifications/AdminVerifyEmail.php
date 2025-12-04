<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminVerifyEmail extends Notification
{
    use Queueable;

    protected $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Verify your admin account')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('Thank you for creating an admin account. Please verify your email address to activate your admin access.')
                    ->action('Verify Email', $this->url)
                    ->line('This verification link will expire in 60 minutes.')
                    ->line('If you did not create this account, no further action is required.');
    }
}
