@props([
    'id' => null,
    'name' => null,
    'label' => null,
    'helper' => null,
])

@php
    // Genera un ID único si no se proporciona uno, para vincular el input y el label.
    $id = $id ?? 'checkbox_' . Str::random(8);
@endphp

{{-- La estructura principal (el div contenedor) se define ahora en la vista de ejemplo --}}
{{-- para máxima fidelidad con la documentación de Flowbite. --}}

<input {{ $attributes->merge([
    'id' => $id,
    'name' => $name,
    'type' => 'checkbox',
    'class' => 'w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600'
    ]) }}
    @if($helper) aria-describedby="{{ $id }}-helper" @endif
>

{{-- El label y el texto de ayuda se manejan con slots para mayor flexibilidad. --}}
@if($slot->isNotEmpty() || $label)
<label for="{{ $id }}" @class([
    'ms-2 text-sm font-medium',
    'text-gray-900 dark:text-gray-300' => !$attributes->has('disabled'),
    'text-gray-400 dark:text-gray-500' => $attributes->has('disabled'),
])>
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @else
        {{ $label }}
    @endif
</label>
@endif
