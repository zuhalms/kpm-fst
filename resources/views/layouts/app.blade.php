<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('img/logo-uin.png') }}">
    <title>Repositori KPM FST - UIN Alauddin Makassar</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-[#121212] text-gray-900 dark:text-gray-100">
    <div class="min-h-screen flex">
        {{-- Sidebar/Navigasi --}}
        @include('layouts.navigation')

        {{-- Content Area --}}
        <main class="flex-grow ml-64 min-h-screen flex flex-col transition-all duration-300">
            
            @if (isset($header))
                <header class="bg-white dark:bg-[#1e1e1e] border-b border-gray-200 dark:border-gray-800 sticky top-0 z-10 transition-colors duration-300">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <div class="p-8 flex-grow">
                {{ $slot }}
            </div>

            {{-- Footer Kustom --}}
            <footer class="p-8 text-center bg-white dark:bg-[#1e1e1e] border-t border-gray-100 dark:border-gray-800 transition-colors duration-300">
                <p class="text-gray-400 dark:text-gray-500 text-[10px] font-bold uppercase tracking-[0.2em]">
                    &copy; {{ date('Y') }} KPM FST UIN Alauddin Makassar - Sistem Manajemen Dokumen
                </p>
            </footer>
        </main>
    </div>
</body>
</html>