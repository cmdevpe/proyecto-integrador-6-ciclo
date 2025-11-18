{{-- resources/views/components/paragraph.blade.php --}}

@props([
    'leading' => false,
    'variant' => 'default',
])

@php
    $finalClasses = match ($variant) {
        'boxed' => 'text-sm font-light text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg text-center',
        'highlight' => 'text-sm font-normal text-primary-700 dark:text-primary-500',
        'meta' => 'text-xs font-medium text-gray-500 dark:text-gray-400',
        default => 'text-gray-500 dark:text-gray-400',
    };

    if ($leading) {
        $finalClasses .= ' text-lg md:text-xl';
    }
@endphp

<p {{ $attributes->merge(['class' => $finalClasses]) }}>
    {{ $slot }}
</p>
