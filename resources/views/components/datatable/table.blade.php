@props([
    'data' => [],
    'visibleTableColumns' => [],
    'sortBy' => 'id',
    'sortDirection' => 'asc',
    'selectable' => false,
])

@php
    $rowIds = $data->pluck('id')->map(fn($id) => (string) $id)->values();
@endphp

<div x-data="{
    rowsPage: @js($rowIds),
    selectedRows: $wire.entangle('selectedRows').live,
    allOnPageChecked() {
        if (this.rowsPage.length === 0) return false;
        const set = new Set(this.rowsPage.map(String));
        const count = this.selectedRows.map(String).filter(id => set.has(id)).length;
        return count === this.rowsPage.length;
    },
    someOnPageChecked() {
        if (this.rowsPage.length === 0) return false;
        const set = new Set(this.rowsPage.map(String));
        const count = this.selectedRows.map(String).filter(id => set.has(id)).length;
        return count > 0 && count < this.rowsPage.length;
    },
    toggleAllOnPage() {
        const page = new Set(this.rowsPage.map(String));
        const selectedOnPage = this.selectedRows.map(String).filter(id => page.has(id));
        if (selectedOnPage.length === this.rowsPage.length) {
            this.selectedRows = this.selectedRows.map(String).filter(id => !page.has(id));
        } else {
            const s = new Set(this.selectedRows.map(String));
            this.rowsPage.forEach(id => s.add(String(id)));
            this.selectedRows = Array.from(s);
        }
    },
}" class="flex flex-col space-y-4 lg:block lg:space-y-0">
    <table class="w-full table-auto text-sm text-left text-gray-500 dark:text-gray-400">
        <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 hidden lg:table-header-group">
            <tr>
                @if ($selectable)
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            <input id="checkbox-all" type="checkbox" @click="toggleAllOnPage()"
                                :checked="allOnPageChecked()" x-bind:indeterminate="someOnPageChecked()"
                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 cursor-pointer">
                            <label for="checkbox-all" class="sr-only">checkbox</label>
                        </div>
                    </th>
                @endif

                @foreach ($visibleTableColumns as $column)
                    <th wire:key="th-{{ $column['field'] }}" scope="col"
                        class="px-4 py-3 {{ $column['type'] !== 'actions' && !empty($column['sortable']) ? 'group cursor-pointer select-none' : '' }}"
                        @if ($column['type'] !== 'actions' && !empty($column['sortable'])) role="button"
                            @click="$wire.setSort('{{ $column['field'] }}')"
                            :aria-sort="('{{ $sortBy }}' === '{{ $column['field'] }}' || '{{ $sortBy }}' === '{{ $column['sort_field'] ?? '' }}') ? '{{ $sortDirection }}' : 'none'" @endif>
                        @if ($column['type'] === 'actions')
                            <span class="sr-only">{{ $column['label'] }}</span>
                        @else
                            <div x-data="{ sortDirection: $wire.entangle('sortDirection') }" class="flex items-center space-x-1">
                                <span>{{ $column['label'] }}</span>
                                @php
                                    $isSorted =
                                        $sortBy === $column['field'] || $sortBy === ($column['sort_field'] ?? '');
                                @endphp
                                <svg class="w-4 h-4 transition-transform duration-200 {{ $isSorted ? 'opacity-100 group-hover:opacity-100' : 'opacity-0 group-hover:opacity-50' }}"
                                    :class="{ 'rotate-180': sortDirection === 'asc' }" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </div>
                        @endif
                    </th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @if (count($visibleTableColumns) > 0)
                @forelse ($data as $row)
                    <tr wire:key="row-{{ $row->id }}" class="block lg:table-row border-b dark:border-gray-700">
                        @if ($selectable)
                            <td
                                class="block lg:table-cell lg:align-middle p-4 lg:px-4 lg:py-3 border-b lg:border-b-0 dark:border-gray-700">
                                <div class="flex items-center justify-between lg:justify-start">
                                    <span
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400 lg:hidden">Seleccionar</span>
                                    <input :value="'{{ $row->id }}'" x-model="selectedRows" type="checkbox"
                                        onclick="event.stopPropagation()"
                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 cursor-pointer">
                                </div>
                            </td>
                        @endif
                        @foreach ($visibleTableColumns as $column)
                            <td wire:key="cell-{{ $row->id }}-{{ $column['field'] }}"
                                class="block lg:table-cell lg:align-middle p-4 lg:px-4 lg:py-3 border-b lg:border-b-0 dark:border-gray-700">
                                <div class="flex justify-between items-center">
                                    <span
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400 lg:hidden">{{ $column['label'] }}</span>

                                    @switch($column['type'])
                                        @case('primary')
                                            <div class="flex items-center whitespace-nowrap text-gray-900 dark:text-white">
                                                @if (isset($column['image_field']))
                                                    <img src="{{ data_get($row, $column['image_field']) }}"
                                                        alt="{{ data_get($row, $column['field']) }}" class="w-auto h-8 mr-3">
                                                @endif
                                                {{ data_get($row, $column['field']) }}
                                            </div>
                                        @break

                                        @case('badge')
                                            @php
                                                $emptyText = $column['empty_text'] ?? 'Sin datos';
                                                $color = $column['color'] ?? 'blue';

                                                if (!empty($column['relation'])) {
                                                    $rel = $column['relation'];
                                                    $value = $row->{$rel} ?? null;
                                                    $displayField = $column['relation_field'] ?? 'name';
                                                } else {
                                                    $value = data_get($row, $column['field']);
                                                    $displayField = null;
                                                }
                                            @endphp

                                            @if ($value instanceof \Illuminate\Support\Collection)
                                                @if ($value->isNotEmpty())
                                                    <div class="flex flex-wrap gap-1">
                                                        @foreach ($value as $item)
                                                            <x-badge
                                                                :color="$color">{{ $displayField ? data_get($item, $displayField) : $item }}</x-badge>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <x-badge color="gray">{{ $emptyText }}</x-badge>
                                                @endif
                                            @elseif(is_array($value))
                                                @if (!empty($value))
                                                    <div class="flex flex-wrap gap-1">
                                                        @foreach ($value as $item)
                                                            <x-badge
                                                                :color="$color">{{ is_array($item) ? $item[$displayField ?? 'name'] ?? '' : $item }}</x-badge>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <x-badge color="gray">{{ $emptyText }}</x-badge>
                                                @endif
                                            @elseif(!blank($value))
                                                <x-badge :color="$color">{{ $value }}</x-badge>
                                            @else
                                                <x-badge color="gray">{{ $emptyText }}</x-badge>
                                            @endif
                                        @break

                                        @case('date')
                                            <span class="whitespace-nowrap text-gray-900 dark:text-white">
                                                {{ data_get($row, $column['field'])?->diffForHumans() }}
                                            </span>
                                        @break

                                        @case('field')
                                            <span class="whitespace-nowrap text-gray-900 dark:text-white">
                                                {{ data_get($row, $column['field']) }}
                                            </span>
                                        @break

                                        @case('index')
                                            @php
                                                $itemIndexOnPage = $loop->parent->iteration;
                                                $currentPage = $data->currentPage();
                                                $perPageCount = $data->perPage();
                                                $totalItemsCount = $data->total();
                                                $rowNumberAscending =
                                                    ($currentPage - 1) * $perPageCount + $itemIndexOnPage;
                                                $rowNumberDescending =
                                                    $totalItemsCount -
                                                    ($currentPage - 1) * $perPageCount -
                                                    ($itemIndexOnPage - 1);
                                                $finalRowNumber =
                                                    $sortDirection === 'desc'
                                                        ? $rowNumberDescending
                                                        : $rowNumberAscending;
                                            @endphp
                                            <span class="whitespace-nowrap text-gray-900 dark:text-white">
                                                {{ $finalRowNumber }}
                                            </span>
                                        @break

                                        @case('actions')
                                            <div x-data="{ open: false }" class="relative">
                                                <button @click="open = !open" x-ref="button"
                                                    class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                                    type="button">
                                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                                <div x-cloak x-show="open" @click.outside="open = false"
                                                    @keydown.escape.window="open = false"
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="transform opacity-0 scale-95"
                                                    x-transition:enter-end="transform opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-75"
                                                    x-transition:leave-start="transform opacity-100 scale-100"
                                                    x-transition:leave-end="transform opacity-0 scale-95"
                                                    class="absolute z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600 ring-1 ring-black ring-opacity-5 right-0">
                                                    <ul class="p-1">
                                                        @foreach ($column['actions'] as $action)
                                                            @if (!(isset($action['event']) && str_starts_with($action['event'], 'delete')))
                                                                @can($action['permission'] ?? null)
                                                                    <li>
                                                                        @switch($action['type'])
                                                                            @case('route')
                                                                                <a href="{{ route($action['route'], $row->id) }}"
                                                                                    class="w-full text-left block py-2 px-4 rounded-md text-sm text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-100 dark:hover:text-white">{{ $action['label'] }}</a>
                                                                            @break

                                                                            @case('event')
                                                                                <button type="button"
                                                                                    class="w-full text-left block py-2 px-4 rounded-md text-sm text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-100 dark:hover:text-white"
                                                                                    @click.prevent="$dispatch('{{ $action['event'] }}', { id: {{ $row->id }} }); open = false">{{ $action['label'] }}</button>
                                                                            @break
                                                                        @endswitch
                                                                    </li>
                                                                @endcan
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                    @foreach ($column['actions'] as $action)
                                                        @if (isset($action['event']) && str_starts_with($action['event'], 'delete'))
                                                            @can($action['permission'] ?? null)
                                                                <div class="p-1">
                                                                    <button type="button"
                                                                        class="w-full text-left block py-2 px-4 rounded-md text-sm text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-100 dark:hover:text-white"
                                                                        @click.prevent="Swal.fire({title: '¿Estás seguro?', text: '¡No podrás revertir esto!', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: '¡Sí, eliminar!', cancelButtonText: 'Cancelar'}).then((result) => { if (result.isConfirmed) { $dispatch('{{ $action['event'] }}', { id: {{ $row->id }} }); open = false; }})">{{ $action['label'] }}</button>
                                                                </div>
                                                            @endcan
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            @break

                                        @endswitch
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($visibleTableColumns) + ($selectable ? 1 : 0) }}"
                                    class="text-center py-10 px-4">
                                    <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="w-16 h-16 mb-4 text-gray-400 dark:text-gray-500">
                                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                            <path d="M4.268 21a2 2 0 0 0 1.727 1H18a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3" />
                                            <path d="m9 18-1.5-1.5" />
                                            <circle cx="5" cy="14" r="3" />
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">No se encontraron
                                            resultados</h3>
                                        @if (!empty($this->search))
                                            <p class="mb-4">
                                                No pudimos encontrar nada para la búsqueda: <strong
                                                    class="font-medium text-gray-800 dark:text-gray-100">{{ $this->search }}</strong>
                                            </p>
                                            <x-button color="light" size="sm" class="px-4 py-2"
                                                @click="$wire.set('search','')">
                                                <x-slot:icon>
                                                    <svg viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                            stroke-linejoin="round"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <path
                                                                d="M4.06189 13C4.02104 12.6724 4 12.3387 4 12C4 7.58172 7.58172 4 12 4C14.5006 4 16.7332 5.14727 18.2002 6.94416M19.9381 11C19.979 11.3276 20 11.6613 20 12C20 16.4183 16.4183 20 12 20C9.61061 20 7.46589 18.9525 6 17.2916M9 17H6V17.2916M18.2002 4V6.94416M18.2002 6.94416V6.99993L15.2002 7M6 20V17.2916"
                                                                stroke="#000000" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                        </g>
                                                    </svg>
                                                </x-slot:icon>
                                                Limpiar búsqueda
                                            </x-button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    @else
                        <tr>
                            <td colspan="1" class="text-center py-10 px-4">
                                <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="w-16 h-16 mb-4 text-gray-400 dark:text-gray-500">
                                        <path
                                            d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49" />
                                        <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                                        <path
                                            d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143" />
                                        <path d="m2 2 20 20" />
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">No hay columnas visibles
                                    </h3>
                                    <p>Por favor, selecciona al menos una columna para mostrar los datos.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
