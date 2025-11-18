<x-card variant="profile" class="mb-4">
    <x-heading as="h3" variant="subtitle">
        {{ __('Active sessions') }}
    </x-heading>

    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse ($sessions as $session)
            <li @class(['pt-4', 'pb-6' => $loop->count != 1])>
                <div class="flex items-center space-x-4">
                    <div class="shrink-0">
                        @switch($session['device_name'])
                            @case('Mobile')
                                <svg class="w-6 h-6 dark:text-white" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 18H12.012M6 5L6 19C6 20.1046 6.89543 21 8 21H16C17.1046 21 18 20.1046 18 19L18 5C18 3.89543 17.1046 3 16 3L8 3C6.89543 3 6 3.89543 6 5Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                </svg>
                            @break

                            @case('Tablet')
                                <svg class="w-6 h-6 dark:text-white" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 18H12.01M8.2 21H15.8C16.9201 21 17.4802 21 17.908 20.782C18.2843 20.5903 18.5903 20.2843 18.782 19.908C19 19.4802 19 18.9201 19 17.8V6.2C19 5.0799 19 4.51984 18.782 4.09202C18.5903 3.71569 18.2843 3.40973 17.908 3.21799C17.4802 3 16.9201 3 15.8 3H8.2C7.0799 3 6.51984 3 6.09202 3.21799C5.71569 3.40973 5.40973 3.71569 5.21799 4.09202C5 4.51984 5 5.07989 5 6.2V17.8C5 18.9201 5 19.4802 5.21799 19.908C5.40973 20.2843 5.71569 20.5903 6.09202 20.782C6.51984 21 7.07989 21 8.2 21Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                </svg>
                            @break

                            @default
                                <svg class="w-6 h-6 dark:text-white" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M3 7C3 5.11438 3 4.17157 3.58579 3.58579C4.17157 3 5.11438 3 7 3H17C18.8856 3 19.8284 3 20.4142 3.58579C21 4.17157 21 5.11438 21 7V13C21 14.8856 21 15.8284 20.4142 16.4142C19.8284 17 18.8856 17 17 17H7C5.11438 17 4.17157 17 3.58579 16.4142C3 15.8284 3 14.8856 3 13V7Z"
                                        stroke="currentColor" stroke-width="2" stroke-linejoin="round"></path>
                                    <path
                                        d="M13.3333 17L14.6667 19V19C15.2366 19.8549 14.6238 21 13.5963 21H10.4037C9.37624 21 8.7634 19.8549 9.33333 19V19L10.6667 17"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                    <path d="M3 13H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                </svg>
                        @endswitch
                    </div>

                    <div class="flex-1 min-w-0">
                        <x-paragraph variant="highlight" class="truncate">
                            {{ $session['browser_name'] }} ({{ $session['platform_name'] }})
                            @if ($session['is_current_device'])
                                <x-badge color="green" pill>{{ __('This device') }}</x-badge>
                            @endif
                        </x-paragraph>

                        <x-paragraph variant="meta" class="truncate">
                            {{ $session['ip_address'] }} • {{ $session['last_active'] }}
                        </x-paragraph>
                    </div>

                    @if (!$session['is_current_device'])
                        <x-button wire:click="logoutSession('{{ $session['id'] }}')"
                            wire:confirm="{{ __('Are you sure you want to log out of this session?') }}" color="light" size="sm">
                            {{ __('Sign out') }}
                        </x-button>
                    @endif
                </div>
            </li>
        @empty
            <li class="pt-4">
                <x-paragraph>
                    {{ __('No active sessions found.') }}
                </x-paragraph>
            </li>
        @endforelse
    </ul>

    @if (count($sessions) > 1)
        <x-button wire:click="logoutAllSessions" wire:loading.attr="disabled">
            {{ __('Log out of all other sessions') }}
        </x-button>
    @endif
</x-card>
