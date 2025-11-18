<?php

namespace App\Sidebar;

use App\Sidebar\Contracts\SidebarItem;
use Illuminate\Support\Facades\Route;

class Link implements SidebarItem
{
    public function __construct(
        public string $text,
        public ?string $route,
        public ?string $icon = null,
        public ?string $permission = null,
        public array $modulePermissions = [],
        public ?array $badge = null
    ) {
    }

    public function authorize(): bool
    {
        if (!$this->permission) {
            return true;
        }
        return auth()->check() && auth()->user()->can($this->permission);
    }

    public function isActive(): bool
    {
        if (!$this->route) {
            return false;
        }
        return request()->routeIs($this->route);
    }

    public function render(): string
    {
        $url = '#';
        $wireNavigate = '';

        if ($this->route && Route::has($this->route)) {
            $url = route($this->route);
            $wireNavigate = 'wire:navigate';
        }

        $isActive = $this->isActive();
        $linkClasses = $isActive ? 'bg-gray-100 dark:bg-gray-700' : '';

        $iconClasses = $isActive
            ? 'text-gray-900 dark:text-white'
            : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white';

        $badgeHtml = '';
        if ($this->badge) {
            $badgeColorClasses = [
                'blue' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                'green' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                'gray' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                'default' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
            ];
            $color = $this->badge['color'] ?? 'default';
            $text = $this->badge['text'];
            $colorClass = $badgeColorClasses[$color];
            $badgeHtml = "<span class=\"inline-flex items-center justify-center px-2 ms-3 text-sm font-medium rounded-full {$colorClass}\">{$text}</span>";
        }

        return <<<HTML
            <li>
                <a href="{$url}" {$wireNavigate} class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {$linkClasses}">
                    <i class="{$this->icon} w-5 text-center transition duration-75 {$iconClasses}"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">{$this->text}</span>
                    {$badgeHtml}
                </a>
            </li>
        HTML;
    }
}
