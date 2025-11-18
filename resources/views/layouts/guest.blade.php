{{-- resources\views\layouts\guest.blade.php --}}

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

<body class="font-sans antialiased">
    <!-- Section Content -->
    <section class="bg-gray-50 dark:bg-gray-900">
        {{ $slot }}
    </section>

    <!-- Livewire Scripts -->
    @livewireScripts

    @if (session('swal'))
        <script>
            Swal.fire(@json(session('swal')));
        </script>
    @endif

    <!-- Scripts -->
    @stack('scripts')
</body>

</html>
