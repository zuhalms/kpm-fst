<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Tambah Dokumen Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#121212] min-h-screen flex flex-col transition-colors duration-300">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 flex-grow">
            <div class="bg-white dark:bg-[#1e1e1e] rounded-[2.5rem] shadow-sm p-10 border border-gray-100 dark:border-gray-800 transition-colors duration-300">
                
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="space-y-8">
                        <div>
                            <label class="block text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Judul Dokumen</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="w-full border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-400 rounded-2xl focus:ring-[#65B700] focus:border-[#65B700] py-4 px-5 text-sm shadow-sm transition-colors duration-300" placeholder="Masukkan judul dokumen..." required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Kategori</label>
                                <select name="category_id" class="w-full border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-2xl focus:ring-[#65B700] focus:border-[#65B700] py-4 px-5 text-sm shadow-sm font-medium transition-colors duration-300" required>
                                    <option value="">— Pilih Kategori —</option>
                                    @foreach($categories as $cat)
                                        {{-- Kategori Induk: Disabled DIBUANG agar bisa diklik --}}
                                        <option value="{{ $cat->id }}" class="font-bold bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                            {{ $cat->name }}
                                        </option>
                                        
                                        {{-- Sub-Kategori --}}
                                        @foreach($cat->children as $child)
                                            <option value="{{ $child->id }}" class="dark:bg-gray-800">
                                                &nbsp;&nbsp;&nbsp;— {{ $child->name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Tahun</label>
                                <input type="number" name="year" value="{{ date('Y') }}" class="w-full border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-2xl focus:ring-[#65B700] focus:border-[#65B700] py-4 px-5 text-sm shadow-sm transition-colors duration-300" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Tags</label>
                                <input type="text" name="tags" value="{{ old('tags') }}" class="w-full border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-400 rounded-2xl focus:ring-[#65B700] focus:border-[#65B700] py-4 px-5 text-sm shadow-sm transition-colors duration-300" placeholder="Contoh: Universitas, Fakultas, Jurusan">
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Pilih File Dokumen</label>
                                <input type="file" name="file" class="w-full text-xs text-gray-400 dark:text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-green-50 dark:file:bg-green-900/20 file:text-[#65B700] dark:file:text-green-400 border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-2xl p-2.5 transition-colors duration-300" required>
                                <p class="mt-2 text-[9px] text-gray-400 dark:text-gray-500 font-bold uppercase italic">* Sistem otomatis mendeteksi tipe file (PDF, DOCX, dll)</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Deskripsi / Keterangan</label>
                            <textarea name="description" rows="4" class="w-full border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-400 rounded-2xl focus:ring-[#65B700] focus:border-[#65B700] text-sm p-5 shadow-sm transition-colors duration-300" placeholder="Tambahkan keterangan jika diperlukan...">{{ old('description') }}</textarea>
                        </div>

                        <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-800/30 rounded-2xl border border-gray-100 dark:border-gray-800 w-fit transition-colors duration-300">
                            <input type="checkbox" name="publish" id="publish" value="1" checked class="w-5 h-5 rounded border-gray-300 dark:border-gray-600 text-[#65B700] focus:ring-[#65B700] dark:bg-gray-800">
                            <label for="publish" class="text-sm font-bold text-gray-700 dark:text-gray-200 cursor-pointer uppercase tracking-tight">Publish Dokumen Secara Publik</label>
                        </div>
                    </div>

                    <div class="mt-12 flex justify-end gap-4 border-t border-gray-100 dark:border-gray-800 pt-8">
                        <a href="{{ route('documents.index') }}" class="px-8 py-3 text-gray-400 dark:text-gray-400 font-bold text-xs uppercase tracking-widest hover:text-gray-600 dark:hover:text-gray-300 transition-all">Batal</a>
                        <button type="submit" class="px-10 py-3.5 bg-[#65B700] hover:bg-[#58a000] text-white rounded-2xl font-black text-sm shadow-xl shadow-green-100 dark:shadow-green-900/30 transition-all uppercase tracking-[0.1em]">
                            Simpan Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </div>
</x-app-layout>