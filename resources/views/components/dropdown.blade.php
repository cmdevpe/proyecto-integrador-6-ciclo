@props([
    'placement' => 'bottom',
    'widthClass' => 'w-full',
    'align' => 'left',
])

@php
    $placementClasses = match ($placement) {
        'top' => 'bottom-full mb-2',
        'right' => 'left-full ms-2 top-0',
        'left' => 'right-full me-2 top-0',
        default => 'top-full mt-2',
    };

    $alignmentClasses = match ($align) {
        'right' => 'origin-top-right right-0',
        default => 'origin-top-left left-0',
    };
@endphp

{{-- El x-data ahora envuelve directamente el trigger y el content --}}
<div x-data="{ open: false }" @keydown.escape.window="open = false" class="relative inline-block text-left">

    {{-- Se elimina el div contenedor. El @click ahora debe ir en el botón del trigger --}}
    {{ $trigger }}

    <div
        x-show="open" x-cloak
        @click.away="open = false"
        x-transition
        class="absolute z-50 bg-white rounded-lg shadow dark:bg-gray-700 divide-y divide-gray-100 dark:divide-gray-600 {{ $placementClasses }} {{ $alignmentClasses }} {{ $widthClass }}"
    >
        {{ $content }}
    </div>

</div>
