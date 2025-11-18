<?php

namespace App\Notifications;

use Carbon\CarbonInterval;
use Carbon\CarbonInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MagicLink extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $url)
    {
        //
    }

    /**
     * Calcula el tiempo de expiración en un formato legible.
     */
    protected function ttlHuman(): string
    {
        $ttl = (int) config('magiclink.ttl', 600);
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
            ->subject(__('Your magic login link'))
            ->greeting(__('Hello!'))
            ->line(__('We received a request to access your account.'))
            ->action(__('Access my account'), $this->url)
            ->line(__('This access link will expire in :time.', ['time' => $this->ttlHuman()]))
            ->line(__('If you did not request this link, you can safely ignore this email.'));
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
