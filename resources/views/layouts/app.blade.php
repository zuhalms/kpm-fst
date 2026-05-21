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
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen flex">
        {{-- Sidebar/Navigasi --}}
        @include('layouts.navigation')

        {{-- Content Area --}}
        <main class="flex-grow ml-64 min-h-screen flex flex-col transition-all duration-300">
            
            @if (isset($header))
                <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <div class="p-8 flex-grow">
                {{ $slot }}
            </div>

            {{-- Footer Kustom --}}
            <footer class="p-8 text-center bg-white border-t border-gray-100">
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-[0.2em]">
                    &copy; {{ date('Y') }} KPM FST UIN Alauddin Makassar - Sistem Manajemen Dokumen
                </p>
            </footer>
        </main>
    </div>
</body>
</html>