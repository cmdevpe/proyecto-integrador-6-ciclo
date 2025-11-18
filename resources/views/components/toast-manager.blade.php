{{-- resources/views/components/toast-manager.blade.php --}}

<div x-data="{
        toasts: [],
        addToast(detail) {
            let toastData = Array.isArray(detail) ? detail[0] : detail;
            toastData.id = Date.now() + Math.random();
            this.toasts.push(toastData);
        },
        removeToast(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
    }"
    @toast.window="addToast($event.detail)"
    class="fixed bottom-5 right-5 z-[60] w-full max-w-xs space-y-4">

    <template x-for="toast in toasts" :key="toast.id">
        <div x-data="{
                show: false,
                init() {
                    setTimeout(() => this.show = true, 100);
                    const timeout = toast.timeout === 0 ? 0 : (toast.timeout || 5000);
                    if (timeout > 0) {
                        setTimeout(() => this.close(), timeout);
                    }
                },
                close() {
                    this.show = false;
                    setTimeout(() => removeToast(toast.id), 300);
                }
            }"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="transform opacity-0 translate-y-2"
            x-transition:enter-end="transform opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="transform opacity-100 translate-y-0"
            x-transition:leave-end="transform opacity-0 translate-y-2"
            class="w-full max-w-xs bg-white rounded-lg shadow-lg dark:bg-gray-800 ring-1 ring-black ring-opacity-5"
            role="alert">

            <x-toast ::toast="toast" />
        </div>
    </template>
</div>

@if (session()->has('toast'))
    <div x-data x-init="$dispatch('toast', {{ json_encode(session('toast')) }})"></div>
@endif
