@props(['tableColumns' => []])

<div x-data="{
    open: false,
    visibleColumns: $wire.entangle('visibleColumns').live,
    allColumnKeys: {{ collect($tableColumns)->pluck('field')->toJson() }},
    toggleAll() {
        if (this.areAllSelected()) {
            this.visibleColumns = [];
        } else {
            this.visibleColumns = this.allColumnKeys;
        }
    },
    areAllSelected() {
        return this.visibleColumns.length === this.allColumnKeys.length;
    }
}" class="relative">
    <button @click="open = !open" class="w-full lg:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
        Columnas
        <svg class="-mr-1 ml-1.5 w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
        </svg>
    </button>
    <div x-show="open" @click.away="open = false" @keydown.escape.window="open = false" x-cloak x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-10 w-56 p-3 bg-white rounded-lg shadow dark:bg-gray-700 ring-1 ring-black ring-opacity-5 mt-2 left-0">
        <ul class="space-y-2 text-sm">
            <li class="flex items-center">
                <input id="header-actions-col-all" type="checkbox" :checked="areAllSelected()" @change="toggleAll()" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500 cursor-pointer">
                <label for="header-actions-col-all" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Todas las columnas</label>
            </li>
            <li>
                <hr class="my-1 border-gray-300 dark:border-gray-500">
            </li>
            @foreach ($tableColumns as $column)
                <li class="flex items-center">
                    <input id="header-actions-col-{{ $column['field'] }}" type="checkbox" value="{{ $column['field'] }}" x-model="visibleColumns" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500 cursor-pointer">
                    <label for="header-actions-col-{{ $column['field'] }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $column['label'] }}</label>
                </li>
            @endforeach
        </ul>
    </div>
</div>
