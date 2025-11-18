{{-- resources\views\components\heading.blade.php --}}

@props([
    'as' => 'h1',
    'variant' => 'h1',
])

@php
    $variantStyles = match ($variant) {
        'h2' => 'text-4xl font-bold dark:text-white',
        'h3' => 'text-3xl font-bold dark:text-white',
        'h4' => 'text-2xl font-bold dark:text-white',
        'h5' => 'text-xl font-bold dark:text-white',
        'h6' => 'text-lg font-bold dark:text-white',
        'auth' => 'text-xl md:text-2xl font-semibold leading-tight tracking-tight text-gray-900 dark:text-white',
        'subtitle' => 'text-xl font-semibold dark:text-white',
        default => 'text-5xl font-extrabold dark:text-white',
    };
@endphp

<{{ $as }} {{ $attributes->merge(['class' => $variantStyles]) }}>
    {{ $slot }}
</{{ $as }}>
