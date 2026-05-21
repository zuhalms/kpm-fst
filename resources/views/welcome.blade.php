<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Repositori UIN Alauddin Makassar</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-uin.png') }}">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .bg-gradient-custom {
            background: radial-gradient(circle at top right, #f0fff4, #ffffff 50%);
        }
        .text-gradient {
            background: linear-gradient(to right, #059669, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="antialiased bg-white bg-gradient-custom min-h-screen flex flex-col" x-data="{ filterOpen: false }">

    <nav class="flex items-center justify-between px-8 py-6 max-w-7xl mx-auto w-full">
        <div class="flex items-center">
            <img src="{{ asset('img/logo-uin.png') }}" alt="Logo UIN" class="h-12 w-auto mr-4">
            <div>
                <h1 class="font-black text-xl text-gray-800 leading-none">Komite Penjamin Mutu</h1>
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-1">Fakultas Sains dan Teknologi</p>
            </div>
        </div>

        <div class="flex items-center">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-green-600 text-white text-sm font-bold rounded-full shadow-lg shadow-green-200 hover:bg-green-700 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2 bg-green-600 text-white text-sm font-bold rounded-full shadow-lg shadow-green-200 hover:bg-green-700 transition">Masuk</a>
                @endauth
            @endif
        </div>
    </nav>

    <main class="flex-grow flex flex-col items-center justify-center px-6 text-center -mt-10">
        <div class="inline-flex items-center px-4 py-1.5 mb-8 rounded-full bg-green-50 border border-green-100">
            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
            <span class="text-[10px] font-black text-green-700 uppercase tracking-widest">Sistem Penjaminan Mutu Internal</span>
        </div>

        <h2 class="text-5xl md:text-7xl font-black text-gray-800 tracking-tighter mb-4">
            Repositori KPM FST <br>
            <span class="text-gradient">UIN Alauddin</span> Makassar
        </h2>

        <span class="text-green-600 font-bold">Gerbang Digital Mutu Fakultas</span>

        <div class="mt-12 w-full max-w-4xl relative">
            <div class="relative group mb-6">
                <div class="absolute inset-0 bg-green-200 blur-2xl opacity-20 group-hover:opacity-30 transition"></div>
                
                {{-- Form Pencarian --}}
                <form action="{{ route('documents.index') }}" method="GET" class="relative flex items-center bg-white p-2 rounded-3xl shadow-2xl border border-gray-100">
                    <div class="pl-6 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" placeholder="Cari dokumen, standar, atau panduan..." class="w-full px-6 py-4 text-lg border-none focus:ring-0 text-gray-700 placeholder-gray-400 font-medium bg-transparent">
                    
                    <button type="button" @click="filterOpen = !filterOpen" class="bg-green-600 text-white px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-green-700 transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter
                        <svg class="w-4 h-4 transition-transform duration-300" :class="filterOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    {{-- Dropdown Panel --}}
                    <div 
                        x-show="filterOpen" 
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-4"
                        class="absolute top-full left-0 right-0 mt-4 bg-white p-8 rounded-[2.5rem] shadow-2xl border border-gray-50 text-left z-50"
                        style="display: none;"
                        @click.away="filterOpen = false"
                    >
                        <div class="flex items-center gap-2 mb-6">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                            <h3 class="font-bold text-gray-800">Filter Dokumen</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6"> {{-- Grid diubah ke 3 kolom --}}
                            {{-- Dropdown Kategori --}}
                            <div class="space-y-2">
                                <label class="flex items-center text-[10px] font-black text-gray-400 uppercase tracking-widest gap-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                    Kategori
                                </label>
                                <select name="category_id" class="w-full bg-gray-50 border-none rounded-xl text-sm font-medium text-gray-600 focus:ring-2 focus:ring-green-500/20 py-3">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Dropdown Tahun --}}
                            <div class="space-y-2">
                                <label class="flex items-center text-[10px] font-black text-gray-400 uppercase tracking-widest gap-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Tahun
                                </label>
                                <select name="year" class="w-full bg-gray-50 border-none rounded-xl text-sm font-medium text-gray-600 focus:ring-2 focus:ring-green-500/20 py-3">
                                    <option value="">Semua Tahun</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Dropdown Tags --}}
                            <div class="space-y-2">
                                <label class="flex items-center text-[10px] font-black text-gray-400 uppercase tracking-widest gap-2">
                                    <span class="text-lg leading-none">#</span>
                                    Tags / Jurusan
                                </label>
                                <select name="tag" class="w-full bg-gray-50 border-none rounded-xl text-sm font-medium text-gray-600 focus:ring-2 focus:ring-green-500/20 py-3">
                                    <option value="">Semua Tags</option>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag }}">{{ $tag }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="bg-green-600 text-white px-10 py-3 rounded-xl font-bold text-sm hover:bg-green-700 transition shadow-lg shadow-green-100">
                                Terapkan & Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="w-full max-w-7xl mx-auto px-8 py-10 flex flex-col md:flex-row justify-between items-center border-t border-gray-50 text-gray-400 mt-20">
        <div class="flex items-center gap-3 mb-4 md:mb-0">
            <img src="{{ asset('img/logo-uin.png') }}" alt="Logo UIN" class="h-8 w-auto grayscale opacity-50">
            <span class="text-xs font-bold uppercase tracking-widest">KPM FST - UIN Alauddin Makassar</span>
        </div>
        <p class="text-[10px] font-bold uppercase tracking-widest">
            © {{ date('Y') }} REPOSITORI KPM. All rights reserved.
        </p>
    </footer>

</body>
</html>