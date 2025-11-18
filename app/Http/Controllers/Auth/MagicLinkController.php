<?php

namespace App\Http\Controllers\Auth;

use App\Models\MagicLink;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MagicLinkController extends Controller
{
    public function verify(string $token)
    {
        $hashedToken = hash('sha256', $token);

        $magicLink = MagicLink::where('token', $hashedToken)->valid()->first();

        if (! $magicLink) {
            return redirect()->route('login')->with('error', 'El enlace no es válido o ha expirado.');
        }

        $magicLink->update(['consumed_at' => now()]);

        Auth::login($magicLink->user);
        
        request()->session()->regenerate();

        return redirect()->intended('/dashboard');
    }
}
