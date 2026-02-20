<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $id = $notifiable->getKey();
        $hash = sha1($notifiable->getEmailForVerification());
        $expiration = now()->addMinutes(config('auth.verification.expire', 60));


        $verifyUrl = URL::temporarySignedRoute(
            'verification.verify',
            $expiration,
            [
                'id' => $id,
                'hash' => $hash
            ]
        );

        $parsedUrl = parse_url($verifyUrl);
        parse_str($parsedUrl['query'] ?? '', $queryParams);
        $signature = $queryParams['signature'] ?? null;

        $url = config('app.frontend_url') . '/verify-email?' . http_build_query([
            'id' => $id,
            'hash' => $hash,
            'signature' => $signature,
            'expires' => $expiration->getTimestamp(),
        ]);

        return (new MailMessage)
            ->subject('Verify Email Address')
            ->line('Click the button below to verify your email address.')
            ->action('Verify Email Address', $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
