<x-app-layout>
    <div class="min-h-screen bg-[#F8F9FA] dark:bg-[#121212] font-sans antialiased text-gray-900 dark:text-gray-100 transition-colors duration-300">
        <div class="flex-1 flex flex-col w-full min-w-0">
            
            {{-- Header --}}
            <header class="bg-white dark:bg-[#1e1e1e] py-4 px-8 flex items-center justify-between border-b border-gray-100 dark:border-gray-800 shadow-sm sticky top-0 z-40 transition-colors duration-300">
                <div class="flex items-center gap-2">
                    <a href="{{ route('documents.index') }}" class="p-2 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </a>
                    <h1 class="text-base font-bold text-gray-800 dark:text-white tracking-tight">Detail Dokumen</h1>
                </div>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('documents.edit', $document->id) }}" class="bg-yellow-400 hover:bg-yellow-500 dark:bg-yellow-500 dark:hover:bg-yellow-600 text-white px-5 py-2 rounded-xl font-bold text-xs shadow-sm dark:shadow-yellow-900/30 transition-all active:scale-95">
                        Edit Dokumen
                    </a>
                    <a href="{{ route('documents.index') }}" class="px-5 py-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 font-bold text-xs transition-all">
                        Kembali
                    </a>
                </div>
            </header>

            <main class="p-8 w-full max-w-7xl mx-auto flex-grow">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    {{-- Kolom Kiri: Info Dokumen --}}
                    <div class="lg:col-span-4 space-y-6">
                        <div class="bg-white dark:bg-[#1e1e1e] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-8 transition-colors duration-300">
                            {{-- Badge Kategori --}}
                            <div class="mb-4">
                                <span class="px-3 py-1.5 bg-[#65B700]/10 dark:bg-[#65B700]/20 text-[#65B700] dark:text-green-400 text-[10px] font-bold uppercase tracking-wider rounded-lg border border-[#65B700]/20 dark:border-[#65B700]/30">
                                    {{ $document->category->name ?? 'Kategori' }}
                                </span>
                            </div>

                            <h2 class="text-2xl font-extrabold text-gray-800 dark:text-white leading-tight mb-6">{{ $document->title }}</h2>

                            {{-- Metadata List --}}
                            <div class="space-y-1 mb-8">
                                <div class="flex justify-between py-3 border-b border-gray-50 dark:border-gray-800 text-sm">
                                    <span class="text-gray-400 dark:text-gray-500 font-medium">Tahun Terbit</span>
                                    <span class="text-gray-800 dark:text-gray-100 font-bold">{{ $document->year }}</span>
                                </div>
                                <div class="flex justify-between py-3 border-b border-gray-50 dark:border-gray-800 text-sm">
                                    <span class="text-gray-400 dark:text-gray-500 font-medium">Tipe File</span>
                                    <span class="text-gray-800 dark:text-gray-100 font-bold">{{ strtoupper($document->file_type) }}</span>
                                </div>
                                <div class="flex justify-between py-3 border-b border-gray-50 dark:border-gray-800 text-sm">
                                    <span class="text-gray-400 dark:text-gray-500 font-medium">Tags</span>
                                    <span class="text-gray-800 dark:text-gray-100 font-bold">{{ $document->tags ?? '-' }}</span>
                                </div>
                            </div>

                            {{-- Tombol Download Utama (Satu saja di sini) --}}
                            <div class="space-y-4">
                                <a href="{{ route('documents.download', $document->id) }}" class="flex items-center justify-center gap-3 w-full bg-[#65B700] hover:bg-[#58a000] text-white py-4 rounded-xl font-bold text-sm shadow-md dark:shadow-green-900/30 transition-all active:scale-95 group">
                                    <svg class="w-5 h-5 group-hover:translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Download Dokumen
                                </a>
                            </div>
                        </div>

                        {{-- Card Deskripsi --}}
                        <div class="bg-white dark:bg-[#1e1e1e] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-8 transition-colors duration-300">
                            <h3 class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Deskripsi Dokumen</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                                {{ $document->description ?? 'Tidak ada informasi deskripsi tambahan untuk dokumen ini.' }}
                            </p>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Preview File --}}
                    <div class="lg:col-span-8">
                        <div class="bg-white dark:bg-[#1e1e1e] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden min-h-[800px] flex flex-col transition-colors duration-300">
                            @php $ext = strtolower($document->file_type); @endphp

                            @if($ext == 'pdf')
                                {{-- Preview PDF --}}
                                <iframe src="{{ asset('storage/' . $document->file_path) }}#view=FitH" class="w-full h-[800px] border-none"></iframe>
                            @elseif(in_array($ext, ['jpg', 'jpeg', 'png']))
                                {{-- Preview Image --}}
                                <div class="p-8 flex justify-center bg-gray-50 dark:bg-gray-900/30 flex-grow transition-colors duration-300">
                                    <img src="{{ asset('storage/' . $document->file_path) }}" class="rounded-xl shadow-lg max-w-full h-auto self-start" alt="Preview Image">
                                </div>
                            @else
                                {{-- Placeholder untuk file yang tidak bisa dipreview (Docx/Xlsx) --}}
                                <div class="flex-grow flex flex-col items-center justify-center p-12 bg-gray-50 dark:bg-gray-900/30 text-center transition-colors duration-300">
                                    <div class="w-20 h-20 bg-white dark:bg-gray-800 rounded-2xl shadow-sm flex items-center justify-center text-gray-300 dark:text-gray-600 mb-6 border border-gray-100 dark:border-gray-700">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Preview Tidak Tersedia</h4>
                                    <p class="text-sm text-gray-400 dark:text-gray-500 max-w-xs mx-auto mb-6">File dengan format <b>{{ strtoupper($document->file_type) }}</b> hanya dapat dilihat dengan cara diunduh.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</x-app-layout>