<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use App\Enums\OtpPurpose;
use App\Services\OtpService;
use Illuminate\Http\Request;
use App\Traits\WithThrottling;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Actions\Auth\LogoutUser;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use App\Actions\Auth\ResendVerificationCode;

#[Layout('layouts.guest')]
#[Title('Verificar código')]
class VerifyCode extends Component
{
    use WithThrottling;

    #[Validate('required|string|digits:6')]
    public string $code = '';

    public ?string $email = null;

    public OtpPurpose $purpose;

    public function mount(): void
    {
        if (auth()->user() && auth()->user()->hasVerifiedAccount()) {
            $this->redirect(route('dashboard'), navigate: true);
            return;
        }

        if (session()->has('email_for_verification')) {
            $this->email = session('email_for_verification');
            $this->purpose = OtpPurpose::EmailVerification;
        } elseif (session()->has('email_for_password_reset')) {
            $this->email = session('email_for_password_reset');
            $this->purpose = OtpPurpose::PasswordReset;
        } else {
            $this->redirect(route('login'));
        }
    }

    public function verify(OtpService $otpService): void
    {
        $this->validate();

        $user = User::firstWhere('email', $this->email);

        $result = $otpService->verify($user, $this->code, $this->purpose);

        if ($result['status'] === 'error') {
            $this->addError('code', $result['message']);
            return;
        }

        match ($this->purpose) {
            OtpPurpose::EmailVerification => $this->completeAccountVerification($user),
            OtpPurpose::PasswordReset => $this->proceedToPasswordReset(),
        };
    }

    public function resend(ResendVerificationCode $resendCode): void
    {
        $throttleKey = $this->getEmailThrottleKey($this->email);
        $this->throttle(key: $throttleKey, maxAttempts: 1, errorField: 'code');
        $resendCode($this->email, $this->purpose);
        $this->hit(key: $throttleKey, decaySeconds: 60);
        session()->flash('status', __('We have resent the 6-digit verification code to your email address.'));
    }

    private function completeAccountVerification(User $user): void
    {
        $user->markAccountAsVerified();
        session()->forget('email_for_verification');
        Auth::login($user, true);
        $this->redirect(
            session()->pull('url.intended', route('dashboard')),
            navigate: true
        );
    }

    private function proceedToPasswordReset(): void
    {
        session()->forget('email_for_password_reset');
        session(['email_for_final_reset' => $this->email]);
        $this->redirect(route('password.reset'), navigate: true);
    }

    public function logout(LogoutUser $logoutUser, Request $request): void
    {
        $logoutUser($request);
        $this->redirect(route('login'));
    }

    public function render()
    {
        return view('livewire.auth.verify-code');
    }
}
