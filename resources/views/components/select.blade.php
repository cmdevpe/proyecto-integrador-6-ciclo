@props(['name', 'id' => null, 'label' => null, 'size' => 'base', 'state' => null, 'disabled' => false])

@php
    $id = $id ?? $name;

    $baseClasses =
        'bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500';

    $sizeClasses = match ($size) {
        'sm' => 'p-2 text-sm',
        'lg' => 'px-4 py-3 text-base',
        default => 'p-2.5 text-sm',
    };

    $stateClasses = '';
    if ($state === 'error') {
        $stateClasses =
            'bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 dark:border-red-500';
    }
    if ($disabled) {
        $stateClasses .= ' cursor-not-allowed';
    }
@endphp

<div>
    @if ($label)
        <label for="{{ $id }}" @class([
            'block mb-2 text-sm font-medium',
            'text-red-700 dark:text-red-500' => $state === 'error',
            'text-gray-900 dark:text-white' => !$state,
        ])>
            {{ $label }}
        </label>
    @endif

    <select id="{{ $id }}" name="{{ $name }}" @if ($disabled) disabled @endif
        {{ $attributes->merge(['class' => trim("$baseClasses $sizeClasses $stateClasses")]) }}>
        {{ $slot }}
    </select>

    @error($name)
        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror
</div>
