{{-- resources/views/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Metatags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>{{ $title ?? config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800,900" rel="stylesheet" />

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/c9f315f0ec.js" crossorigin="anonymous"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- WireUI -->
    <wireui:scripts />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Styles -->
    @stack('css')
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900" x-data="{ sidebarOpen: false }"
    :class="{ 'overflow-hidden': sidebarOpen && window.innerWidth < 640 }" @swal.window="Swal.fire($event.detail[0])"
    @keydown.escape.window="sidebarOpen = false">
    <!-- Navbar -->
    <livewire:partials.navbar />

    <!-- Sidebar -->
    <livewire:partials.sidebar />

    <!-- Main Content -->
    <main class="p-4 sm:ml-64">
        {{ $slot }}
    </main>

    <!-- Toast Manager -->
    <x-toast-manager />

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Sweet Alert -->
    @if (session('swal'))
        <script>
            Swal.fire(@json(session('swal')));
        </script>
    @endif

    <!-- Scripts -->
    @stack('scripts')

    <script>
        document.addEventListener('livewire:init', () => {
            if (window.Echo) {
                const userId = {{ auth()->id() }};
                const userChannel = window.Echo.private(`App.Models.User.${userId}`);

                userChannel.listen('.role-updated', () => {
                    window.location.reload();
                });

                userChannel.listen('.role-update-confirmed', (event) => {
                    console.log('Role update confirmed event received:', event);
                    const count = event.notified_count ?? 0;
                    const roleName = event.role_name ?? 'Sin rol';
                    const message = (count > 0) ?
                        `¡El rol '${roleName}' se actualizó exitosamente!<br>${count} usuario(s) han sido notificados.` :
                        `¡El rol '${roleName}' se actualizó exitosamente!`;

                    Livewire.dispatch('toast', {
                        type: 'success',
                        message: message,
                        timeout: 10000
                    });
                });
            }
        });
    </script>
</body>

</html>
