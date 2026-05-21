<x-guest-layout>
    <div class="flex flex-col items-center justify-center">
        <div class="mb-10 text-center">
            <img class="mx-auto h-24 w-auto mb-4" src="{{ asset('img/logo-uin.png') }}" alt="Logo UIN Alauddin">
            
            <h2 class="text-3xl font-black text-gray-800 tracking-tighter uppercase">
                REPOSITORI KPM
            </h2>
            <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mt-1">
                (Komite Penjamin Mutu)
            </p>
        </div>

        <div class="w-full bg-white p-10 rounded-[2.5rem] shadow-2xl border border-gray-100">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label for="email" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Email</label>
                    <x-text-input id="email" class="block w-full px-4 py-4 bg-gray-50 border-none rounded-2xl text-gray-700 focus:ring-2 focus:ring-green-500/20 font-medium" 
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="superadmin@lpm.ac.id" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-6">
                    <label for="password" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Password</label>
                    <x-text-input id="password" class="block w-full px-4 py-4 bg-gray-50 border-none rounded-2xl text-gray-700 focus:ring-2 focus:ring-green-500/20 font-medium"
                        type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500" name="remember">
                        <span class="ms-2 text-xs font-bold text-gray-500 uppercase tracking-tight">{{ __('Ingat saya') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-xs font-bold text-green-600 hover:text-green-700 uppercase tracking-tight" href="{{ route('password.request') }}">
                            {{ __('Lupa password?') }}
                        </a>
                    @endif
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-lg text-sm font-black uppercase tracking-widest text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                        MASUK KE DASHBOARD
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>