{{-- resources/views/components/form/terms-checkbox.blade.php --}}

@props(['id', 'name'])

<div class="flex items-start">
    <div class="flex items-center h-5">
        <input id="{{ $id }}" name="{{ $name }}" type="checkbox" {{ $attributes->merge(['class' => 'w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800']) }}>
    </div>
    <div class="ml-3 text-sm">
        <label for="{{ $id }}" class="font-light text-gray-500 dark:text-gray-300">
            {{ $slot }}
        </label>
    </div>
</div>
