<?php

namespace App\Listeners;

use App\Events\AccountCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Contracts\MustVerifyAccount;

class SendAccountVerificationNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AccountCreated $event): void
    {
        if ($event->user instanceof MustVerifyAccount && !$event->user->hasVerifiedAccount()) {
            $event->user->sendAccountVerificationNotification();
            session(['email_for_verification' => $event->user->email]);
        }
    }
}
