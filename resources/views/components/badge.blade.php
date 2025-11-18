@props([
    'href' => null,
    'color' => 'blue',
    'size' => 'xs',
    'pill' => false,
    'outline' => false,
    'dismissible' => false,
])
@php
    $tag = $href ? 'a' : 'span';

    $baseClasses = 'font-medium me-2';

    $sizeClasses = match ($size) {
        'sm' => 'px-2 py-1 text-sm',
        default => 'px-2.5 py-0.5 text-xs',
    };

    $shapeClasses = $pill ? 'rounded-full' : 'rounded-sm';

    $colorClasses = match ($color) {
        'gray' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        'red' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
        'green' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        'indigo' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
        'purple' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
        'pink' => 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-300',
        default => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
    };

    $outlineClasses = '';
    if ($outline) {
        $colorClasses = 'bg-transparent';
        $outlineClasses = match ($color) {
            'gray' => 'text-gray-800 dark:text-gray-400 border border-gray-500',
            'red' => 'text-red-800 dark:text-red-400 border border-red-400',
            'green' => 'text-green-800 dark:text-green-400 border border-green-400',
            'yellow' => 'text-yellow-800 dark:text-yellow-300 border border-yellow-300',
            'indigo' => 'text-indigo-800 dark:text-indigo-400 border border-indigo-400',
            'purple' => 'text-purple-800 dark:text-purple-400 border border-purple-400',
            'pink' => 'text-pink-800 dark:text-pink-400 border border-pink-400',
            default => 'text-blue-800 dark:text-blue-400 border border-blue-400',
        };
    }

    $dismissButtonClasses = match ($color) {
        'gray' => 'text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-gray-300',
        'red' => 'text-red-400 hover:bg-red-200 hover:text-red-900 dark:hover:bg-red-800 dark:hover:text-red-300',
        'green' => 'text-green-400 hover:bg-green-200 hover:text-green-900 dark:hover:bg-green-800 dark:hover:text-green-300',
        default => 'text-blue-400 hover:bg-blue-200 hover:text-blue-900 dark:hover:bg-blue-800 dark:hover:text-blue-300',
    };

    $finalClasses = trim("inline-flex items-center {$baseClasses} {$sizeClasses} {$shapeClasses} {$colorClasses} {$outlineClasses}");
@endphp

<{{ $tag }}
        @if($href) href="{{ $href }}" @endif
    @if($dismissible)
        x-data="{ show: true }"
            x-show="show"
            x-transition
    @endif
    {{ $attributes->merge(['class' => $finalClasses]) }}
>
@if(isset($icon))
    {{ $icon->withAttributes(['class' => 'w-2.5 h-2.5 me-1.5']) }}
@endif
{{ $slot }}
@if($dismissible)
    <button

                        @click="show = false"
        type="button"
        class="inline-flex items-center p-1 ms-2 text-sm bg-transparent rounded-sm {{ $dismissButtonClasses }}"
            aria-label="Remove"
        >
            <svg class="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Remove badge</span>
        </button>
@endif
</{{ $tag }}>
