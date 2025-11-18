<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button @click="sidebarOpen = !sidebarOpen" :aria-expanded="sidebarOpen.toString()"
                    aria-controls="logo-sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>

                <x-app-logo href="/" class="ms-2 md:me-24" />
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <x-dropdown widthClass="w-56 ring-1 ring-black ring-opacity-5" align="right">
                        <x-slot:trigger>
                            <button @click="open = !open" type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 transition">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full object-cover" src="{{ $photoUrl }}"
                                    alt="{{ $name }}">
                            </button>
                        </x-slot:trigger>

                        <x-slot:content>
                            <div class="py-3 px-4">
                                <span class="block text-sm font-semibold truncate text-gray-900 dark:text-white">
                                    {{ $name }}
                                </span>

                                <span class="block text-sm truncate text-gray-500 dark:text-gray-400">
                                    {{ $email }}
                                </span>
                            </div>

                            <div class="p-2">
                                <a href="{{ route('profile.show') }}" wire:navigate
                                    class="block rounded-md py-2 px-3 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                                    {{ __('Profile') }}
                                </a>
                            </div>

                            <div class="p-2">
                                <button type="button" wire:click="logout" @click="open = false"
                                    class="w-full flex items-center rounded-md py-2 px-3 text-sm text-red-600 hover:bg-red-50 dark:text-red-500 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2"></path>
                                    </svg>
                                    {{ __('Log Out') }}
                                </button>
                            </div>
                        </x-slot:content>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>
</nav>
