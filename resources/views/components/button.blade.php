{{-- resources\views\components\button.blade.php --}}

@props([
    'href' => null,
    'type' => 'button',
    'color' => 'default',
    'social' => null,
    'size' => 'base',
    'pill' => false,
    'outline' => false,
    'link' => false,
    'wireTarget' => null,
    'navigate' => true,
])

@php
    $tag = $href ? 'a' : 'button';
    $isDisabled = $attributes->has('disabled') && $attributes->get('disabled') !== false;
    $baseClasses = 'inline-flex items-center justify-center font-medium';
    $sizeClasses = match ($size) {
        'xs' => 'px-3 py-2 text-xs',
        'sm' => 'px-3 py-2 text-sm',
        'lg' => 'px-5 py-3 text-base',
        'xl' => 'px-6 py-3.5 text-base',
        default => 'px-5 py-2.5 text-sm',
    };
    $shapeClasses = $pill ? 'rounded-full' : 'rounded-lg';
    $stateClasses = '';
    if ($isDisabled) {
        $stateClasses = 'cursor-not-allowed bg-primary-400 dark:bg-primary-500';
        $color = 'disabled';
    }
    $variantClasses = '';
    if ($link) {
        $variantClasses = 'text-primary-600 dark:text-primary-500 hover:underline focus:ring-0';
        $sizeClasses = '';
        $shapeClasses = '';
    } elseif ($social) {
        $baseClasses .= ' text-center';
        $variantClasses = match ($social) {
            'facebook'
                => 'text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-[#3b5998]/50 dark:focus:ring-[#3b5998]/55',
            'twitter'
                => 'text-white bg-[#1da1f2] hover:bg-[#1da1f2]/90 focus:ring-[#1da1f2]/50 dark:focus:ring-[#1da1f2]/55',
            'github'
                => 'text-white bg-[#24292F] hover:bg-[#24292F]/90 focus:ring-[#24292F]/50 dark:focus:ring-gray-500 dark:hover:bg-[#050708]/30',
            'google'
                => 'text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-[#4285F4]/50 dark:focus:ring-[#4285F4]/55',
            'apple'
                => 'text-white bg-[#050708] hover:bg-[#050708]/90 focus:ring-[#050708]/50 dark:hover:bg-[#050708]/30 dark:focus:ring-gray-600',
            default => '',
        };
    } elseif ($outline) {
        $baseClasses .= ' text-center border';
        $variantClasses = match ($color) {
            'dark'
                => 'text-gray-900 hover:text-white border-gray-800 hover:bg-gray-900 focus:ring-gray-300 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800',
            'green'
                => 'text-green-700 hover:text-white border-green-700 hover:bg-green-800 focus:ring-green-300 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800',
            'red'
                => 'text-red-700 hover:text-white border-red-700 hover:bg-red-800 focus:ring-red-300 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900',
            'yellow'
                => 'text-yellow-400 hover:text-white border-yellow-400 hover:bg-yellow-500 focus:ring-yellow-300 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400 dark:focus:ring-yellow-900',
            'purple'
                => 'text-purple-700 hover:text-white border-purple-700 hover:bg-purple-800 focus:ring-purple-300 dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900',
            default
                => 'text-blue-700 hover:text-white border-blue-700 hover:bg-primary-800 focus:ring-blue-300 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-primary-500 dark:focus:ring-blue-800',
        };
    } else {
        $baseClasses .= ' text-center';
        $variantClasses = match ($color) {
            'alternative'
                => 'text-gray-900 bg-white border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700',
            'dark'
                => 'text-white bg-gray-800 hover:bg-gray-900 focus:ring-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700',
            'light'
                => 'text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-gray-100 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700',
            'green'
                => 'text-white bg-green-700 hover:bg-green-800 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800',
            'red'
                => 'text-white bg-red-700 hover:bg-red-800 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900',
            'yellow' => 'text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-yellow-300 dark:focus:ring-yellow-900',
            'purple'
                => 'text-white bg-purple-700 hover:bg-purple-800 focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900',
            'disabled' => $stateClasses,
            default
                => 'text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800',
        };
    }
@endphp

<{{ $tag }}
    @if ($tag === 'a') href="{{ $href }}" @if ($navigate) wire:navigate @endif
@else type="{{ $type }}" @endif
    @if ($isDisabled) disabled @endif
    @if ($wireTarget) wire:loading.attr="disabled"
        wire:loading.class="opacity-75 cursor-not-allowed"
        wire:target="{{ $wireTarget }}" @endif
    {{ $attributes->merge(['class' => trim("$baseClasses $sizeClasses $variantClasses $shapeClasses")]) }}>
    <span wire:loading.remove wire:target="{{ $wireTarget }}" class="inline-flex items-center justify-center">
        @if (isset($icon))
            <span class="inline-flex items-center justify-center mr-2 -ml-1 h-4 w-4">
                {{ $icon }}
            </span>
        @endif
        {{ $slot }}
    </span>

    <span wire:loading.flex wire:target="{{ $wireTarget }}" class="inline-flex items-center justify-center">
        <svg class="w-5 h-5 mr-3 -ml-1 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>

        @if (isset($loading) && $loading->isNotEmpty())
            <span>{{ $loading }}</span>
        @else
            <span>{{ __('Processing...') }}</span>
        @endif
    </span>
    </{{ $tag }}>
