{{-- resources/views/components/card.blade.php --}}

@props([
    'href' => null,
    'imgSrc' => null,
    'imgAlt' => '',
    'horizontal' => false,
    'variant' => 'default',
    'class' => '',
])

@php
    $tag = $href ? 'a' : 'div';

    $baseClasses = 'bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700';

    $variantClasses = match ($variant) {
        'auth' => 'w-full p-6 sm:p-8 md:mt-0 sm:max-w-md',
        'profile' => 'w-full p-4 sm:p-6',
        default => 'max-w-sm',
    };

    if ($horizontal) {
        $baseClasses .= ' flex flex-col md:flex-row md:max-w-xl';
        if ($tag === 'a') {
            $baseClasses .= ' hover:bg-gray-100 dark:hover:bg-gray-700';
        }
    } elseif ($tag === 'a') {
        $baseClasses .= ' block hover:bg-gray-100 dark:hover:bg-gray-700';
    }
@endphp

<{{ $tag }}
    @if ($tag === 'a') href="{{ $href }}" wire:navigate @endif
    {{ $attributes->merge(['class' => trim("$baseClasses $variantClasses $class")]) }}>

    @if (isset($image))
        {{ $image }}
    @elseif ($imgSrc)
        <img @class([
            'object-cover w-full',
            'h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg' => $horizontal,
            'rounded-t-lg' => !$horizontal,
        ]) src="{{ $imgSrc }}" alt="{{ $imgAlt }}">
    @endif

    {{ $slot }}
</{{ $tag }}>
