@props([
    'data' => [],
    'visibleTableColumns' => [],
    'tableColumns' => [],
    'visibleColumns' => [],
    'sortBy' => 'id',
    'sortDirection' => 'asc',
    'perPage' => 10,
    'perPageOptions' => [10, 25, 50, 100],
    'searchPlaceholder' => 'Buscar…',
    'selectable' => false,
])

@php
    $visCols = collect($tableColumns ?? [])
        ->filter(fn($c) => in_array($c['field'] ?? null, $visibleColumns ?? []))
        ->values()
        ->all();
@endphp

<div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg">
    <div class="flex flex-col lg:flex-row items-center justify-between space-y-4 lg:space-y-0 lg:space-x-4 p-4">
        <div class="w-full lg:w-1/2">
            <x-datatable.search :placeholder="$searchPlaceholder" />
        </div>

        <div
            class="w-full lg:w-auto flex flex-col lg:flex-row space-y-3 lg:space-y-0 items-stretch lg:items-center justify-end lg:space-x-3 flex-shrink-0">
            @if (isset($headerButtons))
                {{ $headerButtons }}
            @endif
            <div class="flex items-center space-x-3 w-full lg:w-auto">
                @if (isset($headerActions))
                    {{ $headerActions }}
                @endif
                <x-datatable.columns-toggle :tableColumns="$tableColumns" />
                <x-datatable.per-page :perPage="$perPage" :perPageOptions="$perPageOptions" />
            </div>
        </div>
    </div>

    <x-datatable.table :data="$data" :visibleTableColumns="$visCols" :sortBy="$sortBy" :sortDirection="$sortDirection" :selectable="$selectable" />

    @if ($data->hasPages())
        <div class="p-4">
            {{ $data->links() }}
        </div>
    @endif
</div>
