<?php

namespace App\Sidebar;

use App\Sidebar\Contracts\SidebarItem;
use Illuminate\Support\Collection;

class Section implements SidebarItem
{
    public Collection $children;

    public function __construct(private string $title)
    {
        $this->children = new Collection();
    }

    public function addChild(SidebarItem $child): self
    {
        $this->children->push($child);
        return $this;
    }

    public function authorize(): bool
    {
        return $this->children->contains(
            fn(SidebarItem $child) => $child->authorize()
        );
    }

    public function isActive(): bool
    {
        return false;
    }

    public function render(): string
    {
        $headerHtml = <<<HTML
            <li>
                <span class="px-3 py-2 text-xs font-semibold tracking-wider text-gray-400 uppercase dark:text-gray-500">
                    {$this->title}
                </span>
            </li>
        HTML;

        $childrenHtml = $this->children
            ->filter(fn(SidebarItem $child) => $child->authorize())
            ->map(fn(SidebarItem $child) => $child->render())
            ->implode('');

        return $headerHtml . $childrenHtml;
    }
}
