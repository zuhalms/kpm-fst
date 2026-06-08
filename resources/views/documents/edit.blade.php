<x-app-layout>
    <div class="min-h-screen bg-[#F8F9FA] dark:bg-[#121212] font-sans antialiased text-gray-900 dark:text-gray-100 transition-colors duration-300">
        <div class="flex-1 flex flex-col w-full min-w-0">
            
            {{-- Header --}}
            <header class="bg-white dark:bg-[#1e1e1e] py-4 px-8 flex items-center justify-between border-b border-gray-100 dark:border-gray-800 shadow-sm sticky top-0 z-40 transition-colors duration-300">
                <div class="flex items-center gap-2">
                    <a href="{{ route('documents.index') }}" class="p-2 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </a>
                    <h1 class="text-base font-bold text-gray-800 dark:text-white tracking-tight">Edit Dokumen</h1>
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
                        <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">
                                {{-- Judul Dokumen --}}
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Judul Dokumen</label>
                                    <input type="text" name="title" value="{{ old('title', $document->title) }}" 
                                        class="block w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-4 focus:ring-[#65B700]/10 focus:border-[#65B700] bg-white dark:bg-gray-800 dark:text-gray-100 transition-all shadow-sm dark:placeholder-gray-400" 
                                        required>
                                    @error('title') <p class="mt-1 text-xs text-red-500 dark:text-red-400 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Kategori --}}
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Kategori</label>
                                        <select name="category_id" class="block w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-4 focus:ring-[#65B700]/10 focus:border-[#65B700] bg-white dark:bg-gray-800 dark:text-gray-100 transition-all">
                                            @foreach($categories as $parent)
                                                <optgroup label="{{ $parent->name }}" class="font-bold text-gray-800 dark:text-gray-100">
                                                    @foreach($parent->children as $child)
                                                        <option value="{{ $child->id }}" {{ $document->category_id == $child->id ? 'selected' : '' }}>
                                                            {{ $child->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Tahun --}}
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Tahun</label>
                                        <input type="number" name="year" value="{{ old('year', $document->year) }}" 
                                            class="block w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-4 focus:ring-[#65B700]/10 focus:border-[#65B700] bg-white dark:bg-gray-800 dark:text-gray-100 transition-all shadow-sm dark:placeholder-gray-400" 
                                            required>
                                    </div>
                                </div>

                                {{-- Tags --}}
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Tags / Jurusan</label>
                                    <input type="text" name="tags" value="{{ old('tags', $document->tags) }}" 
                                        class="block w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-4 focus:ring-[#65B700]/10 focus:border-[#65B700] bg-white dark:bg-gray-800 dark:text-gray-100 transition-all shadow-sm dark:placeholder-gray-400" 
                                        placeholder="Contoh: Teknik Informatika, Skripsi">
                                </div>

                                {{-- File Upload --}}
                                <div class="p-4 bg-gray-50 dark:bg-gray-800/30 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 transition-colors duration-300">
                                    <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Ganti File Dokumen</label>
                                    <input type="file" name="file" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#65B700]/10 dark:file:bg-[#65B700]/20 file:text-[#65B700] dark:file:text-green-400 hover:file:bg-[#65B700]/20 dark:hover:file:bg-[#65B700]/30 transition-all cursor-pointer">
                                    <div class="mt-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span class="text-[11px] text-gray-500 dark:text-gray-400 italic font-medium">File saat ini: {{ basename($document->file_path) }}</span>
                                    </div>
                                    @error('file') <p class="mt-1 text-xs text-red-500 dark:text-red-400 font-bold">{{ $message }}</p> @enderror
                                </div>

                                {{-- Deskripsi --}}
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Deskripsi</label>
                                    <textarea name="description" rows="3" 
                                        class="block w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-4 focus:ring-[#65B700]/10 focus:border-[#65B700] bg-white dark:bg-gray-800 dark:text-gray-100 transition-all shadow-sm dark:placeholder-gray-400">{{ old('description', $document->description) }}</textarea>
                                </div>

                                {{-- Status Aktif (Toggle) --}}
                                <div class="pt-2">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <div class="relative">
                                            <input type="checkbox" name="publish" value="1" {{ $document->status == 'Published' ? 'checked' : '' }} class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 dark:after:border-gray-600 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#65B700]"></div>
                                        </div>
                                        <span class="text-sm font-bold text-gray-700 dark:text-gray-200 group-hover:text-[#65B700] dark:group-hover:text-[#65B700] transition-colors">Terbitkan Dokumen</span>
                                    </label>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="mt-10 pt-6 border-t border-gray-50 dark:border-gray-800 flex items-center justify-end gap-3">
                                <a href="{{ route('documents.index') }}" class="px-6 py-2.5 text-sm font-bold text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-all">
                                    Batal
                                </a>
                                <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 dark:bg-yellow-500 dark:hover:bg-yellow-600 text-white px-8 py-2.5 rounded-xl font-bold text-sm shadow-md dark:shadow-yellow-900/30 transition-all active:scale-95">
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