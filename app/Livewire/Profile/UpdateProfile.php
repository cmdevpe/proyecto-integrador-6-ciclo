<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class UpdateProfile extends Component
{
    #[Validate]
    public string $name = '';

    #[Validate]
    public string $email = '';

    #[Validate('nullable|string|max:20')]
    public string $phone = '';

    #[Validate('nullable|string|max:255')]
    public string $role = '';

    public function mount()
    {
        $user = auth()->user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->role = $user->role ?? '';
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore(auth()->user())],
        ];
    }

    public function updateProfile()
    {
        $user = auth()->user();
        $validated = $this->validate();

        if ($validated['email'] !== $user->email) {
            $validated['email_verified_at'] = null;
        }

        $user->update($validated);

        if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        $this->dispatch('toast', type: 'success', message: __('Profile successfully updated.'));
        $this->dispatch('profile-updated', name: $this->name, email: $this->email);
    }

    public function render()
    {
        return view('livewire.profile.update-profile');
    }
}
