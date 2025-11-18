<?php

namespace App\Sidebar;

use App\Sidebar\Contracts\SidebarItem;
use Illuminate\Support\Collection;

class Submenu implements SidebarItem
{
    public Collection $children;

    public function __construct(
        private string $text,
        private string $icon
    ) {
        $this->children = new Collection();
    }

    public function addChild(SidebarItem $child): self
    {
        $this->children->push($child);
        return $this;
    }

    public function authorize(): bool
    {
        return $this->children->contains(fn(SidebarItem $child) => $child->authorize());
    }

    public function isActive(): bool
    {
        return $this->children->contains(fn(SidebarItem $child) => $child->isActive());
    }

    public function render(): string
    {
        $childrenHtml = $this->children
            ->filter(fn(SidebarItem $child) => $child->authorize())
            ->map(fn(SidebarItem $child) => $child->render())
            ->implode('');

        $isActive = $this->isActive() ? 'true' : 'false';

        return <<<HTML
            <li>
                <div x-data="{ open: {$isActive} }">
                    <button @click="open = !open" type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                        <i class="{$this->icon} w-5 text-center text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"></i>
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{$this->text}</span>
                        <svg :class="{ 'rotate-180': open }" class="w-3 text-center transition-transform duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <ul x-show="open" x-cloak class="py-2 space-y-2">
                        {$childrenHtml}
                    </ul>
                </div>
            </li>
        HTML;
    }
}
