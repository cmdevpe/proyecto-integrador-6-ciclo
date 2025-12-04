<div class="mt-14">
    <x-breadcrumb :items="[
        [
            'label' => __('Dashboard'),
            'url' => route('dashboard'),
        ],
        [
            'label' => __('Productos'),
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
                        Crear nuevo producto
                    </x-button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Producto / SKU</th>
                            <th scope="col" class="px-4 py-3">Categoría</th>
                            <th scope="col" class="px-4 py-3">Marca / Modelo</th>
                            <th scope="col" class="px-4 py-3">Color / Talla</th>
                            <th scope="col" class="px-4 py-3">Estado</th>
                            <th scope="col" class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr wire:key="product-{{ $product->id }}"
                                class="border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="flex flex-col">
                                        <span class="text-base font-semibold">{{ $product->name }}</span>
                                        <span
                                            class="text-xs text-gray-500 font-mono">{{ $product->sku ?? 'SIN SKU' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                        {{ $product->category->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-col text-xs">
                                        <span class="font-semibold text-gray-700 dark:text-gray-200">
                                            {{ $product->brand->name ?? '-' }}
                                        </span>
                                        <span class="text-gray-500">
                                            {{ $product->productModel->name ?? '-' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-2 text-xs">
                                        @if ($product->color)
                                            <div class="flex items-center space-x-1"
                                                title="{{ $product->color->name }}">
                                                <span
                                                    class="w-3 h-3 rounded-full border border-gray-300 dark:border-gray-600"
                                                    style="background-color: {{ $product->color->hex_code ?? '#ccc' }}"></span>
                                                <span>{{ $product->color->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif

                                        <span class="text-gray-300 dark:text-gray-600">|</span>

                                        <span class="font-medium text-gray-700 dark:text-gray-300">
                                            {{ $product->size->name ?? '-' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($product->status)
                                        <span
                                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                            Activo
                                        </span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 flex items-center justify-end space-x-2">
                                    <button wire:click="edit({{ $product->id }})"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        Editar
                                    </button>
                                    <button wire:click="delete({{ $product->id }})"
                                        wire:confirm="¿Estás seguro de eliminar el producto '{{ $product->name }}'?"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8">
                                    <div
                                        class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                        <svg class="w-12 h-12 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <span class="text-lg font-medium">No se encontraron productos</span>
                                        <p class="text-sm">Intenta ajustar tu búsqueda o agrega un nuevo producto.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($products->hasPages())
                <div class="p-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal con Componentes Personalizados -->
    <x-modal name="product-form-modal" maxWidth="2xl" :static="true">
        <x-slot:header>
            <h3 class="text-xl font-semibold">{{ $form->product_id ? 'Editar producto' : 'Crear nuevo producto' }}
            </h3>
        </x-slot:header>
        <x-slot:body>
            <form class="space-y-4 md:space-y-5" wire:submit.prevent="save"
                wire:key="product-form-{{ $form->product_id ?? 'new' }}">

                <!-- Sección Principal -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nombre (Input) -->
                    <div class="md:col-span-2">
                        <x-input wire:model.blur="form.name" type="text" name="form.name" id="name"
                            label="{{ __('Nombre') }}" placeholder="{{ __('Ingresa el nombre del producto') }}"
                            :state="$errors->has('form.name') ? 'error' : null" required autocomplete="name" />
                    </div>

                    <!-- SKU (Input) -->
                    <div>
                        <x-input wire:model.blur="form.sku" type="text" name="form.sku" id="sku"
                            label="{{ __('SKU') }}" placeholder="{{ __('Código único') }}" :state="$errors->has('form.sku') ? 'error' : null" />
                    </div>

                    <!-- Categoría (Select) -->
                    <div>
                        <x-select label="Categoría" name="form.category_id" wire:model.live="form.category_id"
                            :state="$errors->has('form.category_id') ? 'error' : null">
                            <option value="">Seleccionar...</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </x-select>
                    </div>
                </div>

                <!-- Sección Detalles (Grid 2x2) -->
                <div class="border-t pt-4 dark:border-gray-600">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase mb-3">Clasificación</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Marca -->
                        <x-select label="Marca" name="form.brand_id" wire:model="form.brand_id" :state="$errors->has('form.brand_id') ? 'error' : null">
                            <option value="">Ninguna</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </x-select>

                        <!-- Modelo -->
                        <x-select label="Modelo" name="form.product_model_id" wire:model="form.product_model_id">
                            <option value="">Ninguno</option>
                            @foreach ($models as $model)
                                <option value="{{ $model->id }}">{{ $model->name }}</option>
                            @endforeach
                        </x-select>

                        <!-- Color -->
                        <x-select label="Color" name="form.color_id" wire:model="form.color_id">
                            <option value="">Ninguno</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </x-select>

                        <!-- Talla -->
                        <x-select label="Talla" name="form.size_id" wire:model="form.size_id">
                            <option value="">Ninguna</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </x-select>
                    </div>
                </div>

                <!-- Toggle Estado -->
                <div class="flex items-center pt-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="form.status" class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Producto Activo</span>
                    </label>
                </div>

                <!-- Botones de Acción -->
                <div class="flex items-center space-x-2 pt-4 border-t dark:border-gray-600">
                    <x-button type="submit" wireTarget="save" class="px-4 py-2">
                        <x-slot:icon>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                <path fill="currentColor"
                                    d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z" />
                            </svg>
                        </x-slot:icon>
                        <x-slot:loading>
                            {{ $form->product_id ? 'Actualizando...' : 'Creando...' }}
                        </x-slot:loading>
                        {{ $form->product_id ? 'Actualizar producto' : 'Crear nuevo producto' }}
                    </x-button>

                    <x-button class="px-4 py-2" color="light"
                        @click="$dispatch('close-modal', { name: 'product-form-modal' })">
                        Cancelar
                    </x-button>
                </div>
            </form>
        </x-slot:body>
    </x-modal>
</div>
