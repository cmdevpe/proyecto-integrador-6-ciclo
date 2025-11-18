{{-- resources/views/components/input-password.blade.php --}}

@props([
    'name',
    'id' => null,
    'label' => 'Password',
    'placeholder' => '•••••••••',
    'state' => null,
])

@php
    $id = $id ?? $name;
    $isError = $state === 'error';

    $labelClasses = $isError
        ? 'block mb-2 text-sm font-medium text-red-700 dark:text-red-500'
        : 'block mb-2 text-sm font-medium text-gray-900 dark:text-white';

    $baseInputClasses = 'border text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white';
    $normalInputClasses = 'bg-gray-50 border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500';

    $errorInputClasses = 'bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500';

    $finalInputClasses = $baseInputClasses . ' ' . ($isError ? $errorInputClasses : $normalInputClasses);

    $iconButtonClasses = $isError
        ? 'absolute inset-y-0 end-0 flex items-center p-2.5 text-sm font-medium text-red-500 dark:text-red-500'
        : 'absolute inset-y-0 end-0 flex items-center p-2.5 text-sm font-medium text-gray-500 dark:text-gray-400';
@endphp

<div>
    <label for="{{ $id }}" class="{{ $labelClasses }}">{{ $label }}</label>

    <div x-data="{ show: false }" class="relative">
        <input
            :type="show ? 'text' : 'password'"
            id="{{ $id }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => $finalInputClasses]) }}
        >

        <button
            type="button"
            @click="show = !show"
            tabindex="-1"
            class="{{ $iconButtonClasses }}"
        >
            <svg x-show="!show" x-cloak class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>

            <svg x-show="show" x-cloak class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path d="M2.99902 3L20.999 21M9.8433 9.91364C9.32066 10.4536 8.99902 11.1892 8.99902 12C8.99902 13.6569 10.3422 15 11.999 15C12.8215 15 13.5667 14.669 14.1086 14.133M6.49902 6.64715C4.59972 7.90034 3.15305 9.78394 2.45703 12C3.73128 16.0571 7.52159 19 11.9992 19C13.9881 19 15.8414 18.4194 17.3988 17.4184M10.999 5.04939C11.328 5.01673 11.6617 5 11.9992 5C16.4769 5 20.2672 7.94291 21.5414 12C21.2607 12.894 20.8577 13.7338 20.3522 14.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </button>
    </div>

    @error($name)
        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror
</div>
