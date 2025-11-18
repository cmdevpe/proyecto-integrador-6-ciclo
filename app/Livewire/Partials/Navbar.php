<?php

namespace App\Livewire\Partials;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Http\Request;
use App\Actions\Auth\LogoutUser;

class Navbar extends Component
{
    public string $name = '';
    public string $email = '';
    public string $photoUrl = '';

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
        $this->photoUrl = auth()->user()->profile_photo_url;
    }

    #[On('profile-updated')]
    public function refreshProfileInfo(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    #[On('profile-photo-updated')]
    public function refreshPhotoUrl()
    {
        $this->photoUrl = auth()->user()->fresh()->profile_photo_url;
    }

    public function logout(LogoutUser $logoutUser, Request $request): void
    {
        $logoutUser($request);
        $this->redirect(route('login'));
    }

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
