<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Dokumen Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen flex flex-col">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 flex-grow">
            <div class="bg-white rounded-[2.5rem] shadow-sm p-10 border border-gray-100">
                
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="space-y-8">
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Judul Dokumen</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="w-full border-gray-200 rounded-2xl focus:ring-[#65B700] focus:border-[#65B700] py-4 px-5 text-sm shadow-sm" placeholder="Masukkan judul dokumen..." required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Kategori</label>
                                <select name="category_id" class="w-full border-gray-200 rounded-2xl focus:ring-[#65B700] focus:border-[#65B700] py-4 px-5 text-sm shadow-sm font-medium text-gray-700" required>
                                    <option value="">— Pilih Kategori —</option>
                                    @foreach($categories as $cat)
                                        {{-- Kategori Induk: Disabled DIBUANG agar bisa diklik --}}
                                        <option value="{{ $cat->id }}" class="font-bold bg-gray-50 text-gray-900">
                                            {{ $cat->name }}
                                        </option>
                                        
                                        {{-- Sub-Kategori --}}
                                        @foreach($cat->children as $child)
                                            <option value="{{ $child->id }}">
                                                &nbsp;&nbsp;&nbsp;— {{ $child->name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Tahun</label>
                                <input type="number" name="year" value="{{ date('Y') }}" class="w-full border-gray-200 rounded-2xl focus:ring-[#65B700] focus:border-[#65B700] py-4 px-5 text-sm shadow-sm" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Tags</label>
                                <input type="text" name="tags" value="{{ old('tags') }}" class="w-full border-gray-200 rounded-2xl focus:ring-[#65B700] focus:border-[#65B700] py-4 px-5 text-sm shadow-sm" placeholder="Contoh: Universitas, Fakultas, Jurusan">
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Pilih File Dokumen</label>
                                <input type="file" name="file" class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-green-50 file:text-[#65B700] border border-gray-200 rounded-2xl p-2.5" required>
                                <p class="mt-2 text-[9px] text-gray-400 font-bold uppercase italic">* Sistem otomatis mendeteksi tipe file (PDF, DOCX, dll)</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Deskripsi / Keterangan</label>
                            <textarea name="description" rows="4" class="w-full border-gray-200 rounded-2xl focus:ring-[#65B700] focus:border-[#65B700] text-sm p-5 shadow-sm" placeholder="Tambahkan keterangan jika diperlukan...">{{ old('description') }}</textarea>
                        </div>

                        <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-2xl border border-gray-100 w-fit">
                            <input type="checkbox" name="publish" id="publish" value="1" checked class="w-5 h-5 rounded border-gray-300 text-[#65B700] focus:ring-[#65B700]">
                            <label for="publish" class="text-sm font-bold text-gray-700 cursor-pointer uppercase tracking-tight">Publish Dokumen Secara Publik</label>
                        </div>
                    </div>

                    <div class="mt-12 flex justify-end gap-4 border-t pt-8">
                        <a href="{{ route('documents.index') }}" class="px-8 py-3 text-gray-400 font-bold text-xs uppercase tracking-widest hover:text-gray-600 transition-all">Batal</a>
                        <button type="submit" class="px-10 py-3.5 bg-[#65B700] hover:bg-[#58a000] text-white rounded-2xl font-black text-sm shadow-xl shadow-green-100 transition-all uppercase tracking-[0.1em]">
                            Simpan Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </div>
</x-app-layout>