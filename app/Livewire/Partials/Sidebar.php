<?php

namespace App\Livewire\Partials;

use Livewire\Component;
use App\Sidebar\Services\SidebarService;
use Illuminate\Support\Collection;

class Sidebar extends Component
{
    protected Collection $menuItems;

    public function mount(SidebarService $sidebarService): void
    {
        $this->menuItems = $sidebarService->build();
    }

    public function render()
    {
        return view('livewire.partials.sidebar', [
            'menuItems' => $this->menuItems,
        ]);
    }
}
