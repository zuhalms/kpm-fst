<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kategori Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <nav class="flex mb-5 text-gray-500 text-sm font-medium" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('categories.index') }}" class="hover:text-green-600">Manajemen Kategori</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path></svg>
                            <span class="text-gray-400">Tambah Baru</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-10">
                    <div class="mb-8">
                        <h3 class="text-2xl font-black text-gray-800">Detail Kategori</h3>
                        <p class="text-gray-400 text-sm">Silakan lengkapi informasi kategori di bawah ini.</p>
                    </div>

                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Induk Kategori (Opsional)</label>
                                <select name="parent_id" class="w-full bg-gray-50 border-gray-200 rounded-2xl focus:ring-[#65B700] focus:border-[#65B700] py-3.5 text-sm transition-all font-bold text-gray-700">
                                    <option value="">-- Tidak Ada (Kategori Utama) --</option>
                                    
                                    {{-- PERBAIKAN: Loop 7 Kategori Utama (Standar KPM) dari Database --}}
                                    @foreach($categories as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Nama Kategori / Sub Kategori</label>
                                <input type="text" name="name" required placeholder="Contoh: Standar Pendidikan" 
                                    class="w-full bg-gray-50 border-gray-200 rounded-2xl focus:ring-[#65B700] focus:border-[#65B700] py-3.5 text-sm transition-all @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Warna Label</label>
                                    <div class="flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-2xl p-2">
                                        <input type="color" name="color" value="#3B82F6" 
                                            class="w-10 h-10 border-none rounded-lg cursor-pointer bg-transparent">
                                        <span class="text-sm text-gray-500 font-medium">Pilih Identitas Visual</span>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Status Kategori</label>
                                    <div class="flex items-center h-[58px] px-4 bg-gray-50 border border-gray-200 rounded-2xl">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#65B700]"></div>
                                            <span class="ms-3 text-sm font-bold text-gray-600 uppercase tracking-tight">Kategori Aktif</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 flex items-center justify-end gap-4">
                            <a href="{{ route('categories.index') }}" class="px-6 py-3 text-sm font-bold text-gray-400 hover:text-gray-600 transition-all">
                                Batal
                            </a>
                            <button type="submit" class="bg-[#65B700] hover:bg-[#58a000] text-white px-10 py-3.5 rounded-2xl font-black text-sm shadow-lg shadow-green-200 transition-all transform hover:scale-105">
                                Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>