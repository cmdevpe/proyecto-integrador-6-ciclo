{{-- resources\views\components\app-logo.blade.php --}}

@props([
    'href' => '/',
    'navigate' => true,
    'imageClass' => 'h-8 me-3',
    'textClass' => 'self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white',
])

<a @if ($navigate) wire:navigate @endif href="{{ $href }}"
    {{ $attributes->merge(['class' => 'flex items-center text-gray-900 dark:text-white']) }}>
    <img src="{{ config('app.logo', 'https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg') }}"
        class="{{ $imageClass }}" alt="{{ config('app.name', 'Laravel') }}" />

    <span class="{{ $textClass }}">
        {{ config('app.name', 'Laravel') }}
    </span>
</a>
