<div class="mt-14">
    <x-breadcrumb :items="[
        [
            'label' => __('Dashboard'),
            'url' => route('dashboard'),
        ],
        [
            'label' => __('Marcas'),
            'active' => true,
        ],
    ]" :show-title="true" />

    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-4">
        <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-1/2">
                    <form class="flex items-center" x-data="{ search: $wire.entangle('search').live }" @keydown.escape.prevent="search = ''">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                    fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="simple-search" x-ref="searchInput" x-model="search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Buscar..." autocomplete="off">
                            <div x-show="search.length > 0" x-cloak
                                class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <button type="button" @click="search = ''; $refs.searchInput.focus()"
                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-white"
                                    aria-label="Clear search">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div
                    class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                    <x-button size="sm" class="px-4 py-2" @click="$wire.create()">
                        <x-slot:icon>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                <path fill="currentColor"
                                    d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z" />
                            </svg>
                        </x-slot:icon>
                        Crear nueva marca
                    </x-button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">#</th>
                            <th scope="col" class="px-4 py-3">Marca</th>
                            <th scope="col" class="px-4 py-3">Estado</th>
                            <th scope="col" class="px-4 py-3">Fecha de creación</th>
                            <th scope="col" class="px-4 py-3">Última actualización</th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($brands as $brand)
                            <tr wire:key="brand-{{ $brand->id }}"
                                class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $brand->name }}
                                </td>

                                <td class="px-4 py-2">
                                    @if ($brand->status)
                                        <span
                                            class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Activo</span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Inactivo</span>
                                    @endif
                                </td>

                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $brand->created_at->diffForHumans() }}
                                </td>

                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $brand->updated_at->diffForHumans() }}
                                </td>

                                <td class="px-4 py-2 flex items-center justify-end">
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
                                                <li>
                                                    <button type="button"
                                                        class="w-full text-left block py-2 px-4 rounded-md text-sm text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-100 dark:hover:text-white"
                                                        @click.prevent="$wire.edit({{ $brand->id }}); open = false">Editar</button>
                                                </li>
                                            </ul>
                                            <div class="p-1">
                                                <button type="button"
                                                    class="w-full text-left block py-2 px-4 rounded-md text-sm text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-100 dark:hover:text-white"
                                                    @click.prevent="Swal.fire({title: '¿Estás seguro?', text: '¡No podrás revertir esto!', icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: '¡Sí, eliminar!', cancelButtonText: 'Cancelar'}).then((result) => { if (result.isConfirmed) { $wire.delete({{ $brand->id }}); open = false; }})">
                                                    Eliminar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 px-4">
                                    <div
                                        class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="w-16 h-16 mb-4 text-gray-400 dark:text-gray-500">
                                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                            <path
                                                d="M4.268 21a2 2 0 0 0 1.727 1H18a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3" />
                                            <path d="m9 18-1.5-1.5" />
                                            <circle cx="5" cy="14" r="3" />
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">No se
                                            encontraron
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
                                                                stroke="#000000" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"></path>
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
                    </tbody>
                </table>
            </div>
            @if ($brands->hasPages())
                <div class="p-4">
                    {{ $brands->links() }}
                </div>
            @endif
        </div>
    </div>

    <x-modal name="brand-form-modal" maxWidth="lg" :static="true">
        <x-slot:header>
            <h3 class="text-xl font-semibold">{{ $form->brand_id ? 'Editar marca' : 'Crear nueva marca' }}
            </h3>
        </x-slot:header>
        <x-slot:body>
            <form class="space-y-4 md:space-y-5" wire:submit.prevent="save"
                wire:key="brand-form-{{ $form->brand_id ?? 'new' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <x-input wire:model.blur="form.name" type="text" name="form.name" id="name"
                            label="{{ __('Nombre') }}" placeholder="{{ __('Ingresa el nombre de la marca') }}"
                            :state="$errors->has('form.name') ? 'error' : null" required autocomplete="name" />
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <x-button type="submit" wireTarget="save" class="px-4 py-2">
                        <x-slot:icon>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                <path fill="currentColor"
                                    d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z" />
                            </svg>
                        </x-slot:icon>
                        <x-slot:loading>
                            {{ $form->brand_id ? 'Actualizando marca' : 'Creando nuevo marca' }}
                        </x-slot:loading>
                        {{ $form->brand_id ? 'Actualizar marca' : 'Crear nuevo marca' }}
                    </x-button>

                    <x-button class="px-4 py-2" color="light"
                        @click="$dispatch('close-modal', { name: 'brand-form-modal' })">
                        Cancelar
                    </x-button>
                </div>
            </form>
        </x-slot:body>
    </x-modal>
</div>
