<aside class="w-64 bg-gray-900 text-white fixed h-full flex flex-col shadow-2xl z-50">
        <div class="flex items-center px-6 py-8 mb-4">
            <img src="{{ asset('img/logo-uin.png') }}" alt="Logo UIN" class="h-12 w-auto mr-3">
            
            <div>
                <h1 class="text-lg font-black  text-white leading-none tracking-tighter uppercase">
                    KPM FST - UIN ALAUDDIN MAKASSAR
                </h1>
                <p class="text-[9px] font-bold text-green-600 uppercase tracking-[0.2em] mt-1">
                    Repositori Dokumen
                </p>
            </div>
        </div>

    <nav class="flex-grow p-4 space-y-2 mt-4">
        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest px-4 mb-2">Main Menu</p>
        
        <a href="{{ route('dashboard') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-green-600 text-white shadow-lg shadow-green-900/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-sm font-bold">Dashboard</span>
        </a>

        <a href="{{ route('categories.index') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('categories.*') ? 'bg-green-600 text-white shadow-lg shadow-green-900/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <span class="text-sm font-bold">Kategori</span>
        </a>

        <a href="{{ route('documents.index') }}" 
           class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('documents.*') ? 'bg-green-600 text-white shadow-lg shadow-green-900/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
            <span class="text-sm font-bold">Dokumen</span>
        </a>
    </nav>

    <div class="p-4 border-t border-gray-800">
        <div class="flex items-center px-2 py-3 bg-gray-800 rounded-xl mb-4">
            <div class="h-9 w-9 bg-green-500 rounded-lg flex items-center justify-center font-bold text-white shadow-inner">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="ml-3 truncate">
                <p class="text-xs font-bold text-white">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-gray-500 uppercase tracking-tighter">Admin</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2 text-xs text-red-400 hover:text-red-300 font-bold transition">
                KELUAR
            </button>
        </form>
    </div>
</aside>