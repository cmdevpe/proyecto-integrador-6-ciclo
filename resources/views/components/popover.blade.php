{{-- resources/views/components/popover.blade.php --}}

@props([
    'placement' => 'bottom',
    'widthClass' => 'w-96',
])

@php
    $placementClasses = match ($placement) {
        'top' => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
        'right' => 'left-full top-1/2 -translate-y-1/2 ms-2',
        'left' => 'right-full top-1/2 -translate-y-1/2 me-2',
        default => 'top-full left-1/2 -translate-x-1/2 mt-2',
    };
@endphp

<span x-data="{ open: false }" class="relative inline-block">
    <span @mouseenter="open = true" @mouseleave="open = false">
        {{ $trigger }}
    </span>

    <div role="tooltip" :class="{ 'opacity-100 visible': open, 'opacity-0 invisible': !open }"
        @class([
            'absolute z-10 text-sm text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm',
            'dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600',
            'transition-opacity duration-300',
            $placementClasses,
            $widthClass,
        ])>
        {{ $content }}
        <div data-popper-arrow></div>
    </div>
</span>
