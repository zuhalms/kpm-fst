<x-app-layout>
    {{-- Alpine.js x-data utama --}}
    <div class="flex min-h-screen bg-[#F8F9FA] dark:bg-[#121212] font-sans antialiased text-gray-900 dark:text-gray-100 transition-colors duration-300" 
         x-data="{ 
            selectedDocs: [],
            openProfile: false 
         }">
        
        <div class="flex-1 flex flex-col w-full min-w-0">
            
            {{-- Header (Sudah bersih dari duplikasi) --}}
            <header class="bg-white dark:bg-[#1e1e1e] py-4 px-8 flex items-center justify-between border-b border-gray-100 dark:border-gray-800 shadow-sm sticky top-0 z-40 transition-colors duration-300">
                <h1 class="text-base font-bold text-gray-800 dark:text-white tracking-tight">Manajemen Dokumen</h1>
                
                <div class="flex items-center gap-5">
                    {{-- Super Admin Dropdown --}}
                    <div class="relative" x-data="{ openProfile: false }">
                        <div @click="openProfile = !openProfile" @click.away="openProfile = false" class="flex items-center gap-3 pl-5 border-l border-gray-100 dark:border-gray-700 cursor-pointer group">
                            <div class="text-right leading-none">
                                <p class="text-xs font-bold text-gray-800 dark:text-gray-200 group-hover:text-[#65B700] transition-colors">Super Admin</p>
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1 uppercase tracking-wider">KPM FST</p>
                            </div>
                            
                            {{-- Ikon Profile --}}
                            <div :class="openProfile ? 'bg-[#65B700] text-white' : 'bg-[#65B700]/10 text-[#65B700]'" 
                                 class="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:bg-[#65B700] group-hover:text-white shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Dropdown Menu Profil --}}
                        <div x-show="openProfile" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                            class="absolute right-0 mt-3 w-52 bg-white dark:bg-[#1e1e1e] rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 py-2 z-50 overflow-hidden"
                            style="display: none;">
                            
                            <a href="{{ route('profile.edit') }}" 
                            class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-[#65B700] transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                PROFIL SAYA
                            </a>

                            <div class="border-t border-gray-50 dark:border-gray-700 my-1"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-red-500 hover:bg-red-50 transition-colors text-left">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    KELUAR APLIKASI
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-8 w-full mx-auto flex-grow">
                
                {{-- Flash Message Alert --}}
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-xl text-sm font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex items-center justify-between gap-4 mb-8">
                    <div class="flex items-center gap-4 flex-1 max-w-2xl">
                        <div class="flex-1 max-w-sm relative">
                            <form action="{{ route('documents.index') }}" method="GET">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 dark:text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-4 focus:ring-[#65B700]/10 focus:border-[#65B700] bg-white dark:bg-gray-800 dark:text-white transition-all placeholder:text-gray-400 dark:placeholder:text-gray-500" 
                                    placeholder="Cari dokumen berdasarkan judul...">
                            </form>
                        </div>

                        {{-- Form Hapus Massal --}}
                        <form id="deleteMultipleForm" action="{{ route('documents.destroy-multiple') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                        {{-- Tombol Hapus Massal --}}
                        <button 
                            x-show="selectedDocs.length > 0"
                            x-transition
                            @click="handleDeleteMultiple(selectedDocs)"
                            class="bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white px-4 py-2.5 rounded-xl font-bold text-xs shadow-sm flex items-center gap-2 transition-all active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hapus <span x-text="selectedDocs.length"></span> File
                        </button>
                    </div>

                    <a href="{{ route('documents.create') }}" class="bg-[#65B700] hover:bg-[#58a000] text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-sm flex items-center gap-2 transition-all active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Tambah Dokumen
                    </a>
                </div>

                {{-- Kontainer Tabel --}}
                <div class="bg-white dark:bg-[#1e1e1e] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition-colors duration-300">
                    <div class="w-full overflow-visible">
                        <table class="w-full text-left table-auto">
                            <thead>
                                <tr class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest bg-gray-50/50 dark:bg-gray-900/30 border-b border-gray-100 dark:border-gray-800">
                                    <th class="py-4 px-6 w-16 text-center">
                                        <input type="checkbox" 
                                            @change="if($el.checked) { selectedDocs = @js($documents->pluck('id')->toArray()) } else { selectedDocs = [] }"
                                            :checked="selectedDocs.length === {{ $documents->count() }} && {{ $documents->count() }} > 0"
                                            class="rounded border-gray-300 text-[#65B700] focus:ring-[#65B700] transition-all cursor-pointer">
                                    </th>
                                    <th class="py-4 px-4">Judul Dokumen</th>
                                    <th class="py-4 px-4 text-center">Kategori</th>
                                    <th class="py-4 px-4 text-center">Sub Kategori</th>
                                    <th class="py-4 px-4 text-center">Tipe Dokumen</th>
                                    <th class="py-4 px-4 text-center">Tahun</th>
                                    <th class="py-4 px-8 text-center w-28">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                                @forelse($documents as $doc)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors group">
                                        <td class="py-5 px-6 text-center">
                                            <input type="checkbox" 
                                                value="{{ $doc->id }}" 
                                                x-model="selectedDocs"
                                                class="rounded border-gray-300 text-[#65B700] focus:ring-[#65B700] transition-all cursor-pointer">
                                        </td>
                                        <td class="py-5 px-4">
                                            <span class="font-bold text-gray-800 dark:text-gray-200 text-[15px] leading-tight group-hover:text-[#65B700] transition-colors">
                                                {{ $doc->title }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-4 text-center">
                                            <span class="inline-block px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-300 rounded-lg text-[11px] font-bold uppercase tracking-wide">
                                                {{ $doc->category->parent->name ?? $doc->category->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-4 text-center">
                                            <span class="inline-block px-3 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-300 rounded-lg text-[11px] font-bold uppercase tracking-wide">
                                                {{ $doc->category->parent ? $doc->category->name : '-' }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-4 text-center">
                                            <span class="inline-block px-2 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded text-[10px] font-bold uppercase">
                                                {{ $doc->file_type ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-4 text-center">
                                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $doc->year }}</span>
                                        </td>
                                        <td class="py-5 px-8 text-center">
                                            {{-- Dropdown Aksi per Baris --}}
                                            <div x-data="{ open: false }" class="relative inline-block text-left">
                                                <button @click="open = !open" @click.away="open = false" class="p-2 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all focus:outline-none">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                                                    </svg>
                                                </button>

                                                <div x-show="open" 
                                                     x-transition:enter="transition ease-out duration-100"
                                                     x-transition:enter-start="transform opacity-0 scale-95"
                                                     x-transition:enter-end="transform opacity-100 scale-100"
                                                     class="absolute right-0 mt-2 w-40 bg-white dark:bg-[#1e1e1e] rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 z-50 py-1.5 overflow-hidden"
                                                     style="display: none;">
                                                    
                                                    <a href="{{ route('documents.show', $doc->id) }}" 
                                                       class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                        Lihat
                                                    </a>

                                                    <a href="{{ route('documents.edit', $doc->id) }}" 
                                                       class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                        Edit
                                                    </a>

                                                    <div class="border-t border-gray-50 dark:border-gray-700 my-1"></div>

                                                    {{-- Tombol Hapus Satuan --}}
                                                    <button type="button" 
                                                            data-url="{{ route('documents.destroy', $doc->id) }}"
                                                            onclick="handleDeleteSingle(this.getAttribute('data-url'))"
                                                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors text-left">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="py-20 text-center text-sm font-bold text-gray-300 dark:text-gray-600 uppercase tracking-widest">Data Tidak Ditemukan</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6">
                    {{ $documents->links() }}
                </div>
            </main>
        </div>
    </div>

    {{-- FORM GLOBAL UNTUK EKSEKUSI HAPUS SATUAN --}}
    <form id="globalDeleteForm" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function handleDeleteSingle(url) {
            if (!confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
                return;
            }
            
            let form = document.getElementById('globalDeleteForm');
            form.action = url;
            form.submit();
        }
        
        function handleDeleteMultiple(selectedDocs) {
            if (selectedDocs.length === 0) {
                alert('Pilih dokumen yang akan dihapus.');
                return;
            }
            
            if (!confirm('Hapus ' + selectedDocs.length + ' dokumen terpilih?')) {
                return;
            }
            
            let form = document.getElementById('deleteMultipleForm');
            
           
            let oldInputs = form.querySelectorAll('input[name="ids[]"]');
            oldInputs.forEach(input => input.remove());
            
           
            selectedDocs.forEach(id => {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                form.appendChild(input);
            });
            
            form.submit();
        }
    </script>
</x-app-layout>