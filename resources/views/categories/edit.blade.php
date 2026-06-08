<x-app-layout>
    <div class="flex min-h-screen bg-[#F8F9FA] dark:bg-[#121212] font-sans antialiased text-gray-900 dark:text-gray-100 transition-colors duration-300">
        <div class="flex-1 flex flex-col w-full min-w-0">
            
            {{-- Header --}}
            <header class="bg-white dark:bg-[#1e1e1e] py-4 px-8 flex items-center justify-between border-b border-gray-100 dark:border-gray-800 shadow-sm sticky top-0 z-40 transition-colors duration-300">
                <div class="flex items-center gap-2">
                    <a href="{{ route('categories.index') }}" class="p-2 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </a>
                    <h1 class="text-base font-bold text-gray-800 dark:text-white tracking-tight">Edit Kategori</h1>
                </div>
                
                <div class="flex items-center gap-5 text-right leading-none border-l border-gray-100 dark:border-gray-800 pl-5">
                    <div>
                        <p class="text-xs font-bold text-gray-800 dark:text-white">Super Admin</p>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1 uppercase tracking-wider">KPM FST</p>
                    </div>
                    <div class="w-8 h-8 bg-[#65B700]/10 dark:bg-[#65B700]/20 rounded-full flex items-center justify-center text-[#65B700]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                </div>
            </header>

            <main class="p-8 w-full max-w-4xl mx-auto flex-grow">
                <div class="bg-white dark:bg-[#1e1e1e] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden transition-colors duration-300">
                    <div class="p-8">
                        <form action="{{ route('categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                {{-- Kolom Kiri --}}
                                <div class="space-y-6">
                                    {{-- Nama Kategori --}}
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Nama Kategori</label>
                                        <input type="text" name="name" value="{{ old('name', $category->name) }}" 
                                            class="block w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-4 focus:ring-[#65B700]/10 focus:border-[#65B700] bg-white dark:bg-gray-800 dark:text-gray-100 transition-all shadow-sm dark:placeholder-gray-400" 
                                            placeholder="Contoh: Dokumen Akademik" required>
                                        @error('name') <p class="mt-1 text-xs text-red-500 dark:text-red-400 font-bold">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- Induk Kategori --}}
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Induk Kategori (Optional)</label>
                                        <div class="relative">
                                            <select name="parent_id" class="block w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-4 focus:ring-[#65B700]/10 focus:border-[#65B700] bg-white dark:bg-gray-800 dark:text-gray-100 transition-all appearance-none cursor-pointer">
                                                <option value="">Pilih Jika Ingin Menjadi Sub-Kategori</option>
                                                @foreach($parentCategories as $parent)
                                                    <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                                        {{ $parent->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400 dark:text-gray-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Kolom Kanan --}}
                                <div class="space-y-6">
                                    {{-- Warna Label --}}
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Warna Label</label>
                                        <div class="flex items-center gap-3">
                                            <input type="color" name="color" value="{{ old('color', $category->color) }}" 
                                                class="w-14 h-11 border border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer bg-white dark:bg-gray-800 p-1 shadow-sm transition-colors duration-300">
                                            <span class="text-xs text-gray-500 dark:text-gray-400 font-medium italic">Warna akan muncul sebagai indikator kategori</span>
                                        </div>
                                        @error('color') <p class="mt-1 text-xs text-red-500 dark:text-red-400 font-bold">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- Status Aktif --}}
                                    <div class="pt-2">
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <div class="relative">
                                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="sr-only peer">
                                                <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 dark:after:border-gray-600 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#65B700]"></div>
                                            </div>
                                            <span class="text-sm font-bold text-gray-700 dark:text-gray-200 group-hover:text-[#65B700] dark:group-hover:text-[#65B700] transition-colors">Kategori Aktif</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-10 pt-6 border-t border-gray-50 dark:border-gray-800 flex items-center justify-end gap-3">
                                <a href="{{ route('categories.index') }}" class="px-6 py-2.5 text-sm font-bold text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-all">
                                    Batal
                                </a>
                                <button type="submit" class="bg-[#65B700] hover:bg-[#58a000] text-white px-8 py-2.5 rounded-xl font-bold text-sm shadow-md dark:shadow-green-900/30 transition-all active:scale-95">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>