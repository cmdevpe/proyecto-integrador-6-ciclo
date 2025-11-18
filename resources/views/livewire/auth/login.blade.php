{{-- resources\views\livewire\auth\login.blade.php --}}

<div class="flex flex-col items-center justify-center min-h-screen px-6 py-8 mx-auto lg:py-0">
    <x-app-logo href="/" class="mb-6" imageClass="w-8 h-8 mr-2"
        textClass="text-2xl font-semibold dark:text-white" />

    <x-card variant="auth">
        <x-heading as="h1" variant="auth" class="mb-1">
            {{ __('Welcome back!') }} 👋
        </x-heading>

        @if (session('status') || session('error'))
            <x-alert :color="session('status') ? 'success' : 'danger'" class="my-4">
                {{ session('status') ?? session('error') }}
            </x-alert>
        @endif

        @if (config('services.google.client_id') || config('services.github.client_id'))
            <div class="mt-4 flex flex-col gap-3 sm:flex-row">
                @if (config('services.google.client_id'))
                    <x-button href="{{ route('socialite.redirect', 'google') }}" color="light" :navigate="false">
                        <x-slot:icon>
                            <svg class="w-5 h-5 me-2 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                <path fill="#FFC107"
                                    d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z">
                                </path>
                                <path fill="#FF3D00"
                                    d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z">
                                </path>
                                <path fill="#4CAF50"
                                    d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.222,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z">
                                </path>
                                <path fill="#1976D2"
                                    d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.574l6.19,5.238C42.022,35.131,44,30.023,44,24C44,22.659,43.862,21.35,43.611,20.083z">
                                </path>
                            </svg>
                        </x-slot:icon>
                        <span>{{ __('Sign in with Google') }}</span>
                    </x-button>
                @endif

                @if (config('services.github.client_id'))
                    <x-button href="{{ route('socialite.redirect', 'github') }}" color="light" :navigate="false">
                        <x-slot:icon>
                            <svg class="w-5 h-5 me-2 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.477A9.911 9.911 0 0 0 10 .333Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </x-slot:icon>
                        <span>{{ __('Sign in with Github') }}</span>
                    </x-button>
                @endif
            </div>

            <div class="mt-4 flex items-center">
                <div class="flex-grow border-t border-gray-200 dark:border-gray-600"></div>
                <span
                    class="flex-shrink mx-4 text-xs font-medium tracking-wider text-gray-400 uppercase dark:text-gray-500">
                    {{ __('Or') }}
                </span>
                <div class="flex-grow border-t border-gray-200 dark:border-gray-600"></div>
            </div>
        @endif

        <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" wire:submit="login">
            <x-input wire:model.blur="email" type="email" name="email" id="email" label="{{ __('Email') }}"
                placeholder="{{ __('Enter your email') }}" :state="$errors->has('email') ? 'error' : null" required autocomplete="username" />

            <x-input-password wire:model.blur="password" name="password" id="password" label="{{ __('Password') }}"
                placeholder="{{ __('Enter your password') }}" :state="$errors->has('password') ? 'error' : null" required
                autocomplete="current-password" />

            <div class="flex items-center justify-between">
                <x-terms-checkbox wire:model="remember" id="remember" name="remember">
                    {{ __('Remember me') }}
                </x-terms-checkbox>

                @if (Route::has('register'))
                    <x-link href="{{ route('password.request') }}" class="text-sm">
                        {{ __('Forgot your password?') }}
                    </x-link>
                @endif
            </div>

            <x-button type="submit" wireTarget="login" class="w-full">
                <x-slot:loading>
                    {{ __('Signing in...') }}
                </x-slot:loading>
                {{ __('Sign in') }}
            </x-button>

            @if (Route::has('register'))
                <x-paragraph class="text-sm font-light">
                    {{ __("Don't have an account yet?") }}
                    <x-link href="{{ route('register') }}">{{ __('Sign up') }}</x-link>
                </x-paragraph>
            @endif
        </form>
    </x-card>
</div>
