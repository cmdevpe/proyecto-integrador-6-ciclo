@props(['perPage' => 10, 'perPageOptions' => [10,25,50,100]])

<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="w-full lg:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
        {{ $perPage }}
        <svg class="-mr-1 ml-1.5 w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
        </svg>
    </button>
    <div x-show="open" @click.away="open = false" @keydown.escape.window="open = false" x-cloak x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-10 w-20 bg-white rounded-lg divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600 ring-1 ring-black ring-opacity-5 mt-2 left-0">
        <ul class="p-1">
            @foreach ($perPageOptions as $option)
                <button type="button" class="w-full text-left block py-2 px-4 rounded-md text-sm font-medium text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" @click.prevent="$wire.set('perPage', {{ $option }}); open = false">{{ $option }}</button>
            @endforeach
        </ul>
    </div>
</div>
