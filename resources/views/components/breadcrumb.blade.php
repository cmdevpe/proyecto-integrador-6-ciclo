{{-- resources/views/components/breadcrumb.blade.php --}}

@props([
    'items' => [],
    'variant' => 'default',
    'title' => null,
    'showTitle' => false,
])

@php
    $finalTitle = $title;
    if ($showTitle && is_null($finalTitle)) {
        $lastItem = collect($items)->last(fn($item) => $item['active'] ?? false);
        if ($lastItem) {
            $finalTitle = $lastItem['label'];
        }
    }

    $navClasses = ['flex', 'text-gray-700', 'dark:text-gray-400'];
    switch ($variant) {
        case 'solid':
            array_push($navClasses, 'px-5', 'py-3', 'rounded-lg', 'bg-gray-50', 'dark:bg-gray-800');
            break;
        case 'bordered':
            array_push(
                $navClasses,
                'justify-between',
                'px-4',
                'sm:px-5',
                'py-3',
                'border',
                'border-gray-200',
                'rounded-lg',
                'bg-gray-50',
                'dark:bg-gray-800',
                'dark:border-gray-700',
                'sm:flex',
            );
            break;
        case 'page-header':
            array_push($navClasses, 'justify-between');
            break;
    }
@endphp

@if (!empty($items))
    @if ($finalTitle)
        <div>
    @endif

    <nav @class($navClasses) aria-label="Breadcrumb">
        <ol @class([
            'inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse',
            'mb-3 sm:mb-0' => in_array($variant, ['bordered', 'page-header']),
        ])>
            @foreach ($items as $item)
                @if (empty($item['label']))
                    @continue
                @endif

                <li class="inline-flex items-center" @if ($item['active'] ?? false) aria-current="page" @endif>
                    @if ($loop->first && !empty($item['url']) && !$finalTitle)
                        <a href="{{ $item['url'] }}" wire:navigate
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            {{ $item['label'] }}
                        </a>
                    @else
                        <div class="flex items-center">
                            @if (!$loop->first || $finalTitle)
                                @if ($finalTitle)
                                    @if ($loop->first)
                                        <a href="{{ $item['url'] }}" wire:navigate
                                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                            <svg class="w-3 h-3 me-2.5" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                            </svg>
                                            {{ $item['label'] }}
                                        </a>
                                    @else
                                        <svg class="h-5 w-5 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m9 5 7 7-7 7" />
                                        </svg>
                                    @endif
                                @elseif ($variant === 'page-header')
                                    <span class="mx-2 text-gray-400">/</span>
                                @else
                                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                @endif
                            @endif

                            @if (!($loop->first && $finalTitle))
                                @if (!empty($item['dropdown']))
                                    <div x-data="{ open: false }" class="relative">
                                        <button @click="open = !open" @keydown.escape.window="open = false"
                                            class="inline-flex items-center px-3 py-2 text-sm font-normal text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-900 dark:hover:bg-gray-800 dark:text-white dark:focus:ring-gray-700">
                                            @if (!empty($item['icon']))
                                                <svg class="w-3 h-3 me-2" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="{{ $item['icon_fill'] ?? 'currentColor' }}"
                                                    viewBox="0 0 20 20">
                                                    <path stroke="{{ $item['icon_stroke'] ?? 'none' }}"
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="{{ $item['icon'] }}" />
                                                </svg>
                                            @endif
                                            {{ $item['label'] }}
                                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                            </svg>
                                        </button>
                                        <div x-show="open" @click.away="open = false" x-transition
                                            class="absolute z-10 mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow-sm min-w-full dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                                @foreach ($item['dropdown'] as $dropItem)
                                                    @if (!empty($dropItem['label']) && !empty($dropItem['url']))
                                                        <li><a href="{{ $dropItem['url'] }}" wire:navigate
                                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $dropItem['label'] }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @elseif (!empty($item['url']) && empty($item['active']))
                                    <a href="{{ $item['url'] }}" wire:navigate @class([
                                        'inline-flex items-center text-sm font-medium hover:text-blue-600 dark:hover:text-white',
                                        'ms-1 md:ms-2',
                                        'text-gray-700 dark:text-gray-400',
                                    ])>
                                        @if ($loop->first)
                                            <svg class="w-3 h-3 me-2.5" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                            </svg>
                                        @elseif (!empty($item['icon']))
                                            <svg class="w-3 h-3 me-2.5" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path d="{{ $item['icon'] }}" />
                                            </svg>
                                        @endif
                                        {{ $item['label'] }}
                                    </a>
                                @else
                                    <span @class([
                                        'inline-flex items-center text-sm font-medium',
                                        'ms-1 md:ms-2',
                                        'text-gray-500 dark:text-gray-400',
                                    ])>
                                        @if ($loop->first)
                                            <svg class="w-3 h-3 me-2.5" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                            </svg>
                                        @elseif (!empty($item['icon']))
                                            <svg class="w-3 h-3 me-2.5" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path d="{{ $item['icon'] }}" />
                                            </svg>
                                        @endif
                                        {{ $item['label'] }}
                                    </span>
                                    @if (!empty($item['badge']))
                                        <span
                                            class="bg-primary-100 text-blue-800 text-xs font-semibold me-2 px-2 py-0.5 rounded-sm dark:bg-primary-200 dark:text-blue-800 hidden sm:flex ms-2">{{ $item['badge'] }}</span>
                                    @endif
                                @endif
                            @endif
                        </div>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>

    @if ($finalTitle)
        <div class="flex items-center justify-between mt-3">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">{{ $finalTitle }}</h2>
            @if (isset($actions))
                <div>{{ $actions }}</div>
            @endif
        </div>
        </div>
    @endif
@endif
