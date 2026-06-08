<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tight">Dashboard</h2>
                <p class="text-xs text-gray-400 dark:text-gray-500 font-bold uppercase tracking-widest mt-1">Ringkasan Repositori Dokumen</p>
            </div>
            <div class="flex items-center gap-4">
                {{-- Toggle Dark Mode --}}
                <button onclick="toggleDarkMode()" class="text-gray-400 dark:text-gray-500 hover:text-[#65B700] dark:hover:text-[#65B700] transition-colors p-2 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700" title="Ganti Tema">
                    <svg id="moonIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg id="sunIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                </button>
                <a href="{{ route('documents.create') }}" class="px-5 py-2.5 bg-green-600 dark:bg-green-700 text-white text-xs font-black rounded-xl shadow-lg shadow-green-900/20 dark:shadow-green-900/40 hover:bg-green-700 dark:hover:bg-green-800 transition-all uppercase tracking-widest flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                    Upload Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-white dark:bg-[#121212] transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white dark:bg-[#1e1e1e] p-7 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center justify-between hover:shadow-md dark:hover:shadow-gray-900 transition-all group">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">Total Koleksi</p>
                                <p class="text-5xl font-black text-gray-800 dark:text-white mt-1 tracking-tighter">{{ $total_documents }}</p>
                                <p class="text-[10px] font-bold text-green-500 dark:text-green-400 mt-2">Dokumen Aktif</p>
                            </div>
                            <div class="p-5 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-2xl group-hover:scale-110 transition-transform">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-[#1e1e1e] p-7 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center justify-between hover:shadow-md dark:hover:shadow-gray-900 transition-all group">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">Pengelompokan</p>
                                <p class="text-5xl font-black text-gray-800 dark:text-white mt-1 tracking-tighter">{{ $total_categories }}</p>
                                <p class="text-[10px] font-bold text-blue-500 dark:text-blue-400 mt-2">Kategori Tersedia</p>
                            </div>
                            <div class="p-5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl group-hover:scale-110 transition-transform">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-[#1e1e1e] rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden transition-colors duration-300">
                        <div class="p-7 border-b border-gray-50 dark:border-gray-800 flex justify-between items-center bg-gray-50/30 dark:bg-gray-900/30">
                            <h3 class="font-black text-gray-800 dark:text-white uppercase text-xs tracking-widest flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-3 animate-pulse"></span>
                                5 Dokumen Terakhir
                            </h3>
                            <a href="{{ route('documents.index') }}" class="text-[10px] font-black text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 uppercase tracking-tighter">Lihat Semua →</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50/50 dark:bg-gray-900/30">
                                    <tr class="text-gray-400 dark:text-gray-500 text-[10px] uppercase tracking-[0.15em] font-bold">
                                        <th class="px-8 py-5">Item</th>
                                        <th class="px-8 py-5">Kategori</th>
                                        <th class="px-8 py-5 text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                                    @forelse($latest_docs as $doc)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition group">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center">
                                                <div class="p-2.5 bg-red-50 dark:bg-red-900/30 text-red-500 dark:text-red-400 rounded-xl mr-4 group-hover:bg-red-500 group-hover:text-white dark:group-hover:bg-red-500 dark:group-hover:text-white transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-black text-gray-700 dark:text-gray-200 leading-none">{{ $doc->title }}</p>
                                                    <p class="text-[10px] text-gray-400 dark:text-gray-500 font-bold mt-1 uppercase">{{ $doc->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5">
                                            <span class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-300 rounded-lg text-[9px] font-black uppercase border border-indigo-100 dark:border-indigo-800 italic">
                                                {{ $doc->category->name ?? 'Tanpa Kategori' }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <span class="text-[10px] font-black {{ $doc->status == 'Published' ? 'text-green-500 dark:text-green-400' : 'text-gray-300 dark:text-gray-600' }} uppercase tracking-tighter transition-colors">
                                                {{ $doc->status == 'Published' ? 'Published' : 'Stored' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-8 py-16 text-center">
                                            <p class="text-sm text-gray-400 dark:text-gray-500 italic">Belum ada dokumen yang diunggah.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    
                    <div class="bg-white dark:bg-[#1e1e1e] p-7 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-800 transition-colors duration-300">
                        <h3 class="text-xs font-black text-gray-800 dark:text-white uppercase tracking-[0.2em] mb-6 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-orange-500 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Hari Ini
                        </h3>
                        <div class="grid grid-cols-3 gap-3 text-center">
                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                                <p class="text-xl font-black text-gray-800 dark:text-white">{{ $latest_docs->where('created_at', '>=', now()->startOfDay())->count() }}</p>
                                <p class="text-[9px] font-black text-gray-400 dark:text-gray-500 uppercase mt-1">Upload</p>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 text-gray-300 dark:text-gray-600">
                                <p class="text-xl font-black">0</p>
                                <p class="text-[9px] font-black uppercase mt-1">Update</p>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 text-gray-300 dark:text-gray-600">
                                <p class="text-xl font-black">0</p>
                                <p class="text-[9px] font-black uppercase mt-1">Hapus</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-[#1e1e1e] p-7 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-800 transition-colors duration-300">
                        <h3 class="text-xs font-black text-gray-800 dark:text-white uppercase tracking-[0.2em] mb-6">Distribusi Data</h3>
                        <div class="space-y-5">
                            @if($total_documents > 0)
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-tighter">Kapasitas Repositori</span>
                                    <span class="text-[11px] font-black text-gray-800 dark:text-gray-200">{{ $total_documents }} / 1000</span>
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-gray-800 h-2 rounded-full overflow-hidden">
                                    <div class="bg-green-500 dark:bg-green-600 h-full transition-all duration-1000" style="width: {{ min(($total_documents / 1000) * 100, 100) }}%"></div>
                                </div>
                                <p class="text-[9px] text-gray-400 dark:text-gray-500 font-bold italic">Batas kapasitas aman: 1.000 dokumen.</p>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-[10px] text-gray-400 dark:text-gray-500 font-bold uppercase">Data Belum Tersedia</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white dark:bg-[#1e1e1e] p-7 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-800 transition-colors duration-300">
                        <h3 class="text-xs font-black text-gray-800 dark:text-white uppercase tracking-[0.2em] mb-6">Log Terakhir</h3>
                        <div class="space-y-6 relative before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-gray-100 dark:before:bg-gray-800">
                            @forelse($latest_docs as $log)
                            <div class="relative pl-8">
                                <div class="absolute left-0 top-1 w-6 h-6 bg-white dark:bg-[#1e1e1e] border-4 border-green-500 dark:border-green-600 rounded-full"></div>
                                <p class="text-[11px] font-black text-gray-700 dark:text-gray-200 uppercase tracking-tighter">Penambahan Dokumen</p>
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 leading-tight mt-0.5">Sistem berhasil mengarsipkan "{{ $log->title }}" ke kategori {{ $log->category->name ?? 'Umum' }}.</p>
                            </div>
                            @empty
                            <div class="text-center">
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 uppercase font-bold">Belum ada aktivitas</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Initialize dark mode on page load
    (function() {
        const isDark = localStorage.getItem('darkMode') === 'true';
        if (isDark) {
            document.documentElement.classList.add('dark');
            updateDarkModeIcon(true);
        } else {
            document.documentElement.classList.remove('dark');
            updateDarkModeIcon(false);
        }
    })();

    function toggleDarkMode() {
        const html = document.documentElement;
        const isDark = html.classList.contains('dark');
        
        if (isDark) {
            html.classList.remove('dark');
            localStorage.setItem('darkMode', 'false');
        } else {
            html.classList.add('dark');
            localStorage.setItem('darkMode', 'true');
        }
        
        updateDarkModeIcon(!isDark);
    }

    function updateDarkModeIcon(isDark) {
        const sun = document.getElementById('sunIcon');
        const moon = document.getElementById('moonIcon');
        if (isDark) {
            sun.classList.remove('hidden');
            moon.classList.add('hidden');
        } else {
            sun.classList.add('hidden');
            moon.classList.remove('hidden');
        }
    }
</script>