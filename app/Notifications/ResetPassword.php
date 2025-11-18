<?php

namespace App\Notifications;

use Carbon\CarbonInterval;
use Carbon\CarbonInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $otp)
    {
    }

    protected function ttlHuman(): string
    {
        $ttl = (int) config('otp.ttl', 600);
        $ttl = max(600, $ttl);

        return CarbonInterval::seconds($ttl)
            ->cascade()
            ->locale(config('app.locale', 'es'))
            ->forHumans([
                'parts' => 1,
                'short' => false,
                'syntax' => CarbonInterface::DIFF_ABSOLUTE,
            ]);
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
            ->subject(__('Reset Your Password'))
            ->greeting(__('Hello!'))
            ->line(__('You are receiving this email because we received a password reset request for your account.'))
            ->line(__('Your password reset code is:'))

            ->line(new HtmlString(
                '<div style="background-color: #f2f4f6; border-radius: 8px; text-align: center; padding: 20px 0; margin: 25px 0;">' .
                    '<span style="font-size: 28px; font-weight: bold; letter-spacing: 4px; color: #1f2937;">' .
                        $this->otp .
                    '</span>' .
                '</div>'
            ))

            ->line(__('This code will expire in :time.', ['time' => $this->ttlHuman()]))
            ->line(__('If you did not request a password reset, no further action is required.'));
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
