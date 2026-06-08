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

    <script>
        // Load dark mode from localStorage on page load
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>

    <style>
        .bg-gradient-custom {
            background: radial-gradient(circle at top right, #f0fff4, #ffffff 50%);
        }
        .bg-gradient-custom-dark {
            background: radial-gradient(circle at top right, #1a3a1f, #121212 50%);
        }
        .text-gradient {
            background: linear-gradient(to right, #059669, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .dark .text-gradient {
            background: linear-gradient(to right, #86efac, #4ade80);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="antialiased bg-white dark:bg-[#121212] bg-gradient-custom dark:bg-gradient-custom-dark min-h-screen flex flex-col transition-colors duration-300" x-data="{ filterOpen: false }">

    <nav class="w-full border-b border-gray-100/50 dark:border-gray-800/50 bg-white/40 dark:bg-gray-900/40 backdrop-blur-sm sticky top-0 z-50 transition-colors duration-300">
        <div class="flex items-center justify-between px-8 py-4 max-w-7xl mx-auto w-full">
            <div class="flex items-center">
                <img src="{{ asset('img/logo-uin.png') }}" alt="Logo UIN" class="h-12 w-auto mr-4">
                <div>
                    <h1 class="font-black text-xl text-gray-800 dark:text-white leading-none transition-colors duration-300">Komite Penjamin Mutu</h1>
                    <p class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mt-1 transition-colors duration-300">Fakultas Sains dan Teknologi</p>
                </div>
            </div>

            <div class="flex items-center">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-green-600 dark:bg-green-600 text-white text-sm font-bold rounded-full shadow-lg shadow-green-200 dark:shadow-green-900/30 hover:bg-green-700 dark:hover:bg-green-700 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-green-600 dark:bg-green-600 text-white text-sm font-bold rounded-full shadow-lg shadow-green-200 dark:shadow-green-900/30 hover:bg-green-700 dark:hover:bg-green-700 transition">Masuk</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <main class="flex-grow w-full max-w-7xl mx-auto px-6 flex flex-col items-center pt-12 pb-16">
        
        <div class="inline-flex items-center px-4 py-1.5 mb-6 rounded-full bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800 transition-colors duration-300">
            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
            <span class="text-[10px] font-black text-green-700 dark:text-green-400 uppercase tracking-widest transition-colors duration-300">Sistem Penjaminan Mutu Internal</span>
        </div>

        <h2 class="text-4xl md:text-6xl font-black text-gray-800 dark:text-white tracking-tighter mb-4 text-center leading-tight transition-colors duration-300">
            Repositori KPM FST <br>
            <span class="text-gradient">UIN Alauddin</span> Makassar
        </h2>

        <span class="text-green-600 dark:text-green-400 font-bold mb-10 text-center transition-colors duration-300">Gerbang Digital Mutu Fakultas</span>

        <div class="w-full max-w-4xl mb-10">
            <div class="relative group mb-4">
                <div class="absolute inset-0 bg-green-200 dark:bg-green-900/30 blur-2xl opacity-20 group-hover:opacity-30 transition"></div>
                
                <form action="{{ route('documents.index') }}" method="GET" class="relative flex items-center bg-white dark:bg-[#1e1e1e] p-2 rounded-3xl shadow-2xl dark:shadow-2xl dark:shadow-black/30 border border-gray-100 dark:border-gray-800 transition-colors duration-300">
                    <input type="hidden" name="sub" value="1">

                    <div class="pl-6 text-gray-400 dark:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari dokumen, standar, atau panduan..." class="w-full px-6 py-4 text-lg border-none focus:ring-0 text-gray-700 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 font-medium bg-transparent transition-colors duration-300">
                    
                    <button type="submit" class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 p-4 rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-700 transition mr-2 flex-shrink-0" title="Cari Langsung">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>

                    <button type="button" @click="filterOpen = !filterOpen" class="bg-green-600 dark:bg-green-600 text-white px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-green-700 dark:hover:bg-green-700 transition flex items-center gap-2 flex-shrink-0 dark:shadow-green-900/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter
                        <svg class="w-4 h-4 transition-transform duration-300" :class="filterOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </form>
            </div>

            <div 
                x-show="filterOpen" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-4"
                class="w-full bg-white dark:bg-[#1e1e1e] p-8 rounded-[2.5rem] shadow-2xl dark:shadow-2xl dark:shadow-black/30 border border-gray-100 dark:border-gray-800 text-left mt-4 transition-colors duration-300"
                style="display: none;"
            >
                <form action="{{ route('documents.index') }}" method="GET">
                    <input type="hidden" name="sub" value="1">
                    <input type="hidden" name="search" value="{{ request('search') }}">

                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                            <h3 class="font-bold text-gray-800 dark:text-white transition-colors duration-300">Filter Dokumen</h3>
                        </div>
                        
                        @if(request()->has('sub'))
                            <a href="{{ route('documents.index') }}" class="text-xs font-bold uppercase tracking-wider text-red-500 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 transition">
                                Bersihkan Hasil Pencarian ✕
                            </a>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="flex items-center text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest gap-2">Kategori</label>
                            <select name="category_id" class="w-full bg-gray-50 dark:bg-gray-800 border-none dark:border-gray-700 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-200 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 py-3 cursor-pointer transition-colors duration-300">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="flex items-center text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest gap-2">Sub Kategori</label>
                            <select name="sub_category_id" class="w-full bg-gray-50 dark:bg-gray-800 border-none dark:border-gray-700 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-200 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 py-3 cursor-pointer transition-colors duration-300">
                                <option value="">Semua Sub Kategori</option>
                                @foreach($categories as $category)
                                    @foreach($category->children as $child)
                                        <option value="{{ $child->id }}" {{ request('sub_category_id') == $child->id ? 'selected' : '' }}>{{ $category->name }} - {{ $child->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="flex items-center text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest gap-2">Tipe Dokumen</label>
                            <select name="file_type" class="w-full bg-gray-50 dark:bg-gray-800 border-none dark:border-gray-700 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-200 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 py-3 cursor-pointer transition-colors duration-300">
                                <option value="">Semua Tipe</option>
                                @foreach($fileTypes as $type)
                                    <option value="{{ $type }}" {{ request('file_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="flex items-center text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest gap-2">Tahun</label>
                            <select name="year" class="w-full bg-gray-50 dark:bg-gray-800 border-none dark:border-gray-700 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-200 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 py-3 cursor-pointer transition-colors duration-300">
                                <option value="">Semua Tahun</option>
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="flex items-center text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest gap-2">Tags / Jurusan</label>
                            <select name="tag" class="w-full bg-gray-50 dark:bg-gray-800 border-none dark:border-gray-700 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-200 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 py-3 cursor-pointer transition-colors duration-300">
                                <option value="">Semua Tags</option>
                                @foreach($tags as $tag)
                                    <option value="{{ $tag }}" {{ request('tag') == $tag ? 'selected' : '' }}>{{ $tag }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-green-600 dark:bg-green-600 text-white px-10 py-3 rounded-xl font-bold text-sm hover:bg-green-700 dark:hover:bg-green-700 transition shadow-lg shadow-green-100 dark:shadow-green-900/30">
                            Terapkan & Cari
                        </button>
                    </div>
                </form>
            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="flex items-center text-[10px] font-black text-gray-400 uppercase tracking-widest gap-2">Tahun</label>
                            <select name="year" class="w-full bg-gray-50 border-none rounded-xl text-sm font-medium text-gray-600 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 py-3 cursor-pointer">
                                <option value="">Semua Tahun</option>
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="flex items-center text-[10px] font-black text-gray-400 uppercase tracking-widest gap-2">Tags / Jurusan</label>
                            <select name="tag" class="w-full bg-gray-50 border-none rounded-xl text-sm font-medium text-gray-600 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 py-3 cursor-pointer">
                                <option value="">Semua Tags</option>
                                @foreach($tags as $tag)
                                    <option value="{{ $tag }}" {{ request('tag') == $tag ? 'selected' : '' }}>{{ $tag }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-green-600 text-white px-10 py-3 rounded-xl font-bold text-sm hover:bg-green-700 transition shadow-lg shadow-green-100">
                            Terapkan & Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if(request()->has('sub'))
            <div class="w-full max-w-4xl text-left bg-white dark:bg-[#1e1e1e] rounded-3xl p-6 shadow-sm dark:shadow-lg dark:shadow-black/20 border border-gray-100 dark:border-gray-800 transition-all duration-300">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 px-2 flex items-center justify-between transition-colors duration-300">
                    <span>Hasil Pencarian Dokumen</span>
                    <span class="text-xs bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 px-3 py-1 rounded-full font-black uppercase tracking-wider transition-colors duration-300">Total: {{ $documents->total() }}</span>
                </h3>

                @if($documents->isEmpty())
                    <div class="py-12 text-center text-gray-400 dark:text-gray-500 transition-colors duration-300">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="font-medium text-sm">Dokumen tidak ditemukan untuk kriteria filter tersebut.</p>
                    </div>
                @else
                    <div class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach($documents as $doc)
                            <div class="py-4 px-2 hover:bg-gray-50/80 dark:hover:bg-gray-800/50 rounded-2xl transition-colors duration-300 flex items-center justify-between group">
                                <div class="space-y-1 pr-4">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-xs font-bold px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 tracking-wide transition-colors duration-300">{{ $doc->file_type }}</span>
                                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 transition-colors duration-300">{{ $doc->year }}</span>
                                        @if($doc->category)
                                            <span class="text-xs text-green-600 dark:text-green-400 font-semibold bg-green-50/50 dark:bg-green-900/20 px-2 py-0.5 rounded-md transition-colors duration-300">{{ $doc->category->name }}</span>
                                        @endif
                                    </div>
                                    <h4 class="font-bold text-gray-800 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors duration-300 text-base">{{ $doc->title }}</h4>
                                    @if($doc->tags)
                                        <p class="text-xs text-gray-400 dark:text-gray-500 transition-colors duration-300">Tags: <span class="text-gray-500 dark:text-gray-400 font-medium transition-colors duration-300">{{ $doc->tags }}</span></p>
                                    @endif
                                </div>
                                
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    <a href="{{ route('documents.download', $doc) }}" class="p-2.5 bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-green-50 dark:hover:bg-green-900/20 hover:text-green-600 dark:hover:text-green-400 rounded-xl transition-colors duration-300" title="Unduh Dokumen">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $documents->links() }}
                    </div>
                @endif
            </div>
        @endif
    </main>

    <footer class="w-full bg-white dark:bg-[#1e1e1e] border-t border-gray-100 dark:border-gray-800 py-6 mt-auto transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-8 flex flex-col md:flex-row justify-between items-center text-gray-400 dark:text-gray-500 gap-4 transition-colors duration-300">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logo-uin.png') }}" alt="Logo UIN" class="h-8 w-auto grayscale opacity-50">
                <span class="text-xs font-bold uppercase tracking-widest text-gray-500 dark:text-gray-400 transition-colors duration-300">KPM FST - UIN Alauddin Makassar</span>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 transition-colors duration-300">
                © {{ date('Y') }} REPOSITORI KPM. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>