<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ResetUserPassword
{
    public function __invoke(string $email, string $password): void
    {
        $user = User::firstWhere('email', $email);

        $user->update([
            'password' => Hash::make($password),
            'remember_token' => Str::random(60),
        ]);
    }
}
