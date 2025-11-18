{{-- resources\views\components\link.blade.php --}}

@props([
    'href' => '#',
    'underline' => 'hover',
    'color' => 'primary',
])

@php
    $underlineClasses = match ($underline) {
        'always' => 'underline hover:no-underline',
        'none' => 'no-underline',
        default => 'hover:underline',
    };

    $colorClasses = match ($color) {
        'gray' => 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200',
        'blue' => 'text-blue-600 dark:text-blue-500',
        default => 'text-primary-600 dark:text-primary-500',
    };
@endphp

<a
    href="{{ $href }}"
    wire:navigate
    {{ $attributes->merge(['class' => "inline-flex items-center font-medium $colorClasses $underlineClasses"]) }}
>
    {{ $slot }}
</a>
