<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Models\MagicLink;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Notifications\MagicLink as MagicLinkNotification;

class SendMagicLink
{
    public function __invoke(string $email): void
    {
        $user = User::firstWhere('email', $email);
        $plainTextToken = Str::random(64);
        $hashedToken = hash('sha256', $plainTextToken);
        $ttl = max(600, (int) config('magiclink.ttl', 600));

        MagicLink::create([
            'user_id' => $user->id,
            'token' => $hashedToken,
            'expires_at' => now()->addSeconds($ttl),
        ]);

        $url = URL::route('login.magic.verify', ['token' => $plainTextToken]);

        $user->notify(new MagicLinkNotification($url));
    }

}
