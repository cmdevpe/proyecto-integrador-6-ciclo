<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
#[Title('Usuarios')]
class User extends Component
{
    public function render()
    {
        return view('livewire.admin.user');
    }
}
