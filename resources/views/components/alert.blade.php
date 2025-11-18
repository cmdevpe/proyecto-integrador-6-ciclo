@props([
    'color' => 'info',
    'icon' => false,
    'dismissible' => false,
    'title' => null,
])
@php
    $colorClasses = match ($color) {
        'danger' => 'text-red-800 bg-red-50 dark:bg-gray-800 dark:text-red-400',
        'success' => 'text-green-800 bg-green-50 dark:bg-gray-800 dark:text-green-400',
        'warning' => 'text-yellow-800 bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300',
        'dark' => 'text-gray-800 bg-gray-50 dark:bg-gray-800 dark:text-gray-300',
        default => 'text-blue-800 bg-blue-50 dark:bg-gray-800 dark:text-blue-400',
    };
    $buttonDismissClasses = match($color) {
        'danger' => 'bg-red-50 text-red-500 focus:ring-red-400 hover:bg-red-200 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700',
        'success' => 'bg-green-50 text-green-500 focus:ring-green-400 hover:bg-green-200 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700',
        'warning' => 'bg-yellow-50 text-yellow-500 focus:ring-yellow-400 hover:bg-yellow-200 dark:bg-gray-800 dark:text-yellow-300 dark:hover:bg-gray-700',
        'dark' => 'bg-gray-50 text-gray-500 focus:ring-gray-400 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white',
        default => 'bg-blue-50 text-blue-500 focus:ring-blue-400 hover:bg-blue-200 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700',
    };
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition
    {{ $attributes->merge(['class' => "p-4 text-sm rounded-lg {$colorClasses}"]) }}
    role="alert"
>
    @if (isset($iconSlot))
        <div class="flex items-center">
            {{ $iconSlot->withAttributes(['class' => 'shrink-0 inline w-4 h-4 me-3']) }}
            <div class="flex-grow">
                @if($title)
                    <span class="font-medium">{{ $title }}</span>
                @endif
                {{ $slot }}
            </div>
        </div>
    @elseif ($icon)
        <div class="flex items-center">
            @switch($color)
                @case('danger')
                    <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    @break
                @case('success')
                    <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                    @break
                @default
                    <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
            @endswitch
            <div class="flex-grow">
                @if($title)
                    <span class="font-medium">{{ $title }}</span>
                @endif
                {{ $slot }}
            </div>
        </div>
    @else
        @if($title)
            <span class="font-medium">{{ $title }}</span>
        @endif
        {{ $slot }}
    @endif

    @if ($dismissible)
        <button
            @click="show = false"
            type="button"
            class="ms-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 p-1.5 inline-flex items-center justify-center h-8 w-8 {{ $buttonDismissClasses }}"
            aria-label="Close"
        >
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    @endif
</div>
