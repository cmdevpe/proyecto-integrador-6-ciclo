<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\SocialAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Notifications\SocialAccountPassword;
use App\Contracts\MustVerifyAccount;

class SocialiteController extends Controller
{
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $socialAccount = SocialAccount::where('provider_name', $provider)
                ->where('provider_id', $socialUser->getId())
                ->first();

            if ($socialAccount) {
                Auth::login($socialAccount->user);
                return redirect()->intended('/dashboard');
            }

            $user = User::where('email', $socialUser->getEmail())->first();

            if (!$user) {
                $generatedPassword = Str::random(12);

                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make($generatedPassword),
                ]);

                if ($user instanceof MustVerifyAccount) {
                    $user->markAccountAsVerified();
                }

                $user->notify(new SocialAccountPassword($generatedPassword));
            } else {
                if ($user instanceof MustVerifyAccount && !$user->hasVerifiedAccount()) {
                    $user->markAccountAsVerified();
                }
            }

            $user->socialAccounts()->create([
                'provider_name' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar_url' => $socialUser->getAvatar(),
            ]);

            if (!$user->profile_photo_path) {
                $user->forceFill([
                    'profile_photo_path' => $socialUser->getAvatar(),
                ])->save();
            }

            Auth::login($user);
            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Hubo un problema al autenticar. Por favor, intenta de nuevo.');
        }
    }
}
