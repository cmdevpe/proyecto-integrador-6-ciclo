<?php

namespace App\Livewire\Profile;

use App\Support\SessionDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Validate;

class ActiveSession extends Component
{
    #[Validate('required|string|current_password')]
    public string $password = '';

    public array $sessions = [];

    public function mount(): void
    {
        $this->getSessions();
    }

    public function getSessions(): void
    {
        if (config('session.driver') !== 'database') {
            $this->sessions = [];
            return;
        }

        $this->sessions = DB::table(config('session.table', 'sessions'))
            ->where('user_id', Auth::id())
            ->orderBy('last_activity', 'desc')
            ->get()
            ->map(fn($session) => new SessionDetails($session))
            ->toArray();
    }

    public function logoutAllSessions()
    {
        $this->validate();
        Auth::logoutOtherDevices($this->password);
        $this->getSessions();
        $this->reset('password');
        $this->dispatch('sessions-logout-all');
    }

    public function logoutSession(string $sessionId)
    {
        DB::table(config('session.table', 'sessions'))
            ->where('id', $sessionId)
            ->where('user_id', auth()->id())
            ->delete();

        $this->getSessions();
        $this->dispatch('session-logout');
    }

    public function render()
    {
        return view('livewire.profile.active-session');
    }
}
