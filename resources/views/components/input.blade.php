{{-- resources\views\components\input.blade.php --}}

@props([
    'type' => 'text',
    'name',
    'id' => null,
    'label' => null,
    'placeholder' => '',
    'value' => '',
    'helperText' => null,
    'state' => null,
    'size' => 'base',
    'icon' => null,
    'addOn' => null,
    'disabled' => false,
    'readonly' => false,
])

@php
    $id = $id ?? $name;
    $baseInputClasses = 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500';
    $sizeClasses = match ($size) {
        'sm' => 'p-2 text-xs',
        'lg' => 'p-4 text-base',
        default => 'p-2.5 text-sm',
    };
    $stateClasses = '';
    if ($state === 'success') {
        $stateClasses = 'bg-green-50 border-green-500 text-green-900 dark:text-green-400 placeholder-green-700 dark:placeholder-green-500 focus:ring-green-500 focus:border-green-500 dark:border-green-500';
    } elseif ($state === 'error') {
        $stateClasses = 'bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500';
    }
    if ($disabled || $readonly) {
        $stateClasses .= ' cursor-not-allowed bg-gray-100 dark:text-gray-400';
    }
@endphp

<div>
    @if ($label)
        <label for="{{ $id }}" @class([
            'block mb-2 text-sm font-medium',
            'text-green-700 dark:text-green-500' => $state === 'success',
            'text-red-700 dark:text-red-500' => $state === 'error',
            'text-gray-900 dark:text-white' => !$state,
        ])>
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        @if ($icon || isset($iconSlot))
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                @if (isset($iconSlot))
                    {{ $iconSlot }}
                @else
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                        <path d="{{ $icon }}"/>
                    </svg>
                @endif
            </div>
        @endif
        <input
            type="{{ $type }}"
            id="{{ $id }}"
            name="{{ $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            @if ($disabled) disabled @endif
            @if ($readonly) readonly @endif
            {{ $attributes->merge(['class' => trim("$baseInputClasses $sizeClasses $stateClasses") . ($icon || isset($iconSlot) ? ' ps-10' : '')]) }}
        >
    </div>

    @error($name)
        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror

    @if ($helperText && !$errors->has($name))
        <p @class([
            'mt-2 text-sm',
            'text-green-600 dark:text-green-500' => $state === 'success',
            'text-red-600 dark:text-red-500' => $state === 'error',
            'text-gray-500 dark:text-gray-400' => !$state,
        ])>
            {!! $helperText !!}
        </p>
    @endif
</div>
