<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SocialAccountPassword extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $password)
    {
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
        return (new MailMessage)
            ->subject(__('Your account has been created'))
            ->greeting(__('Welcome!'))
            ->line(__('An account has been created for you using your social profile.'))
            ->line(__('You can also log in using the following temporary password:'))
            ->line(new HtmlString(
                '<div style="background-color: #f2f4f6; border-radius: 8px; text-align: center; padding: 20px 0; margin: 25px 0;">' .
                    '<span style="font-size: 28px; font-weight: bold; letter-spacing: 4px; color: #1f2937;">' .
                        $this->password .
                    '</span>' .
                '</div>'
            ))
            ->line(__('For security reasons, we strongly recommend that you change this password after your first login.'))
            ->line(__('Thank you for using our application!'));
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
