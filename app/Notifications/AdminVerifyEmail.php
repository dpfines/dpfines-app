<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;

class AdminVerifyEmail extends Notification
{
    use Queueable;

    protected $url;
    public $user;

    public function __construct(string $url, User $user)
    {
        $this->url = $url;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Verify your admin account')
                    ->greeting('Hello ' . $this->user->name . ',')
                    ->line('Thank you for creating an admin account. Please verify your email address to activate your admin access.')
                    ->action('Verify Email', $this->url)
                    ->line('This verification link will expire in 60 minutes.')
                    ->line('If you did not create this account, no further action is required.');
    }
}
