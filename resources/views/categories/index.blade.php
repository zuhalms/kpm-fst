<x-app-layout>
    <div class="flex min-h-screen bg-[#F8F9FA] transition-colors duration-300" id="mainWrapper">
        <div class="flex-1 flex flex-col w-full">
            
            {{-- Header dengan Fitur Dark Mode & User Dropdown --}}
            <header class="bg-white py-4 px-8 flex items-center justify-between border-b border-gray-100 sticky top-0 z-40 transition-colors duration-300" id="mainHeader">
                <h1 class="text-xl font-bold text-gray-800" id="headerTitle">Manajemen Kategori</h1>
                
                <div class="flex items-center gap-6">
                    {{-- Toggle Terang/Gelap --}}
                    <button onclick="toggleDarkMode()" class="text-gray-400 hover:text-[#65B700] transition-colors p-2 rounded-lg bg-gray-50 border border-gray-100" title="Ganti Tema">
                        <svg id="moonIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg id="sunIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                        </svg>
                    </button>

                    {{-- Super Admin Dropdown --}}
                    <div x-data="{ userOpen: false }" class="relative">
                        <div @click="userOpen = !userOpen" @click.away="userOpen = false" class="flex items-center gap-3 cursor-pointer group">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-bold text-gray-700 group-hover:text-[#65B700] transition-colors" id="userNameText">{{ Auth::user()->name ?? 'Super Admin' }}</p>
                                <p class="text-[10px] text-gray-400 uppercase tracking-tighter">Administrator</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-[#65B700]/10 flex items-center justify-center text-[#65B700] font-bold border border-[#65B700]/20">
                                SA
                            </div>
                            <svg class="w-4 h-4 text-gray-400 transition-transform" :class="userOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>

                        {{-- Dropdown Menu --}}
                        <div x-show="userOpen" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 z-[100] py-2 overflow-hidden"
                            style="display: none;">
                            
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-[#65B700] transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Profil Saya
                            </a>

                            <div class="border-t border-gray-50 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-500 hover:bg-red-50 transition-colors text-left">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Keluar Sistem
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-8 w-full max-w-[98%] mx-auto flex-grow">
                
                {{-- Notifikasi --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-600 rounded-xl text-sm font-bold flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif
                
                {{-- Form Filter Utama --}}
                <form action="{{ route('categories.index') }}" method="GET" id="categoryFilterForm" class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    <div class="flex-1 min-w-[400px] relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-[#65B700] focus:border-[#65B700] bg-white transition-all shadow-sm" 
                            placeholder="Cari kategori...">
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <select name="per_page" onchange="document.getElementById('categoryFilterForm').submit()" 
                                class="appearance-none bg-white border border-gray-200 text-gray-600 text-sm rounded-xl focus:ring-[#65B700] py-3 pl-4 pr-10 shadow-sm transition-all cursor-pointer">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>

                        <a href="{{ route('categories.create') }}" class="bg-[#65B700] hover:bg-[#58a000] text-white px-6 py-3 rounded-xl font-bold text-sm shadow-md flex items-center gap-2 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Kategori
                        </a>
                    </div>
                </form>

                <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-visible transition-colors duration-300" id="tableContainer">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b bg-gray-50/30">
                                <th class="py-5 px-8">Nama Kategori</th>
                                <th class="py-5 px-4 text-center">Total Dokumen</th>
                                <th class="py-5 px-4 text-center">Status</th>
                                <th class="py-5 px-8 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($categories as $category)
                                <tr class="hover:bg-[#F8F9FA] transition-colors group">
                                    <td class="py-4 px-8">
                                        <div class="flex items-center gap-3">
                                            <div class="w-3 h-3 rounded-full shadow-sm" style="background-color: {{ $category->color }}"></div>
                                            <span class="font-semibold text-gray-700 text-sm tracking-tight capitalize">{{ $category->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="px-4 py-1.5 bg-[#EBE4FF] text-[#916BFF] rounded-lg font-bold text-[10px] uppercase">
                                            {{ $category->getTotalDocumentsCount() }} File
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="px-4 py-1.5 {{ $category->is_active ? 'bg-[#E6F6EC] text-[#22C55E]' : 'bg-red-50 text-red-400' }} rounded-lg font-bold text-[10px] uppercase">
                                            {{ $category->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-8 text-right">
                                        <div x-data="{ open: false }" class="relative inline-block text-left">
                                            <button @click="open = !open" @click.away="open = false" class="p-2 text-gray-400 hover:text-[#65B700] hover:bg-gray-100 rounded-lg transition-all focus:outline-none">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                                                </svg>
                                            </button>

                                            <div x-show="open" x-cloak
                                                 x-transition:enter="transition ease-out duration-100"
                                                 x-transition:enter-start="transform opacity-0 scale-95"
                                                 x-transition:enter-end="transform opacity-100 scale-100"
                                                 class="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-xl border border-gray-100 z-50 py-1.5 overflow-hidden">
                                                
                                                <a href="{{ route('categories.edit', $category->id) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-blue-600 hover:bg-blue-50 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                    Edit
                                                </a>

                                                <div class="border-t border-gray-50 my-1"></div>

                                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="block">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Hapus kategori ini? Semua sub-kategori di dalamnya juga akan terhapus.')" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors text-left">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-32 text-center text-gray-400 text-sm uppercase font-bold tracking-widest">
                                        Belum ada kategori ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        Menampilkan <span class="font-semibold">{{ $categories->firstItem() ?? 0 }}</span> ke <span class="font-semibold">{{ $categories->lastItem() ?? 0 }}</span> dari <span class="font-semibold">{{ $categories->total() }}</span> kategori
                    </p>
                    <div class="pagination-custom">
                        {{ $categories->links() }}
                    </div>
                </div>

            </main>
        </div>
    </div>

    {{-- Script untuk Toggle Dark Mode --}}
    <script>
        function toggleDarkMode() {
            const wrapper = document.getElementById('mainWrapper');
            const header = document.getElementById('mainHeader');
            const headerTitle = document.getElementById('headerTitle');
            const container = document.getElementById('tableContainer');
            const userName = document.getElementById('userNameText');
            const sun = document.getElementById('sunIcon');
            const moon = document.getElementById('moonIcon');

            // Toggle Visual
            if (wrapper.classList.contains('bg-[#F8F9FA]')) {
                // Ke Dark Mode
                wrapper.classList.replace('bg-[#F8F9FA]', 'bg-[#121212]');
                header.classList.replace('bg-white', 'bg-[#1e1e1e]');
                header.classList.replace('border-gray-100', 'border-gray-800');
                headerTitle.classList.replace('text-gray-800', 'text-white');
                container.classList.replace('bg-white', 'bg-[#1e1e1e]');
                container.classList.replace('border-gray-100', 'border-gray-800');
                if(userName) userName.classList.replace('text-gray-700', 'text-gray-200');
                
                sun.classList.remove('hidden');
                moon.classList.add('hidden');
            } else {
                // Ke Light Mode
                wrapper.classList.replace('bg-[#121212]', 'bg-[#F8F9FA]');
                header.classList.replace('bg-[#1e1e1e]', 'bg-white');
                header.classList.replace('border-gray-800', 'border-gray-100');
                headerTitle.classList.replace('text-white', 'text-gray-800');
                container.classList.replace('bg-[#1e1e1e]', 'bg-white');
                container.classList.replace('border-gray-800', 'border-gray-100');
                if(userName) userName.classList.replace('text-gray-200', 'text-gray-700');

                sun.classList.add('hidden');
                moon.classList.remove('hidden');
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>