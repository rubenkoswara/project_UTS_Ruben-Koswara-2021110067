<x-guest-layout>
    {{-- LOGO AREA --}}
    <div class="mb-6 flex justify-center">
        <a href="/">
            {{-- Mengganti x-application-logo dengan SVG modern (Misalnya Ikon Kilat) --}}
            <svg class="w-16 h-16 text-indigo-600 transform hover:scale-105 transition duration-300" 
                 xmlns="http://www.w3.org/2000/svg" 
                 fill="none" 
                 viewBox="0 0 24 24" 
                 stroke="currentColor" 
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            {{-- Hapus: <x-application-logo class="w-14 h-14 fill-current text-indigo-600 transform hover:scale-105 transition duration-300" /> --}}
        </a>
    </div>

    {{-- Kartu Formulir Login --}}
    <div class="w-full sm:max-w-md px-8 py-10 bg-white shadow-2xl hover:shadow-3xl transition duration-500 overflow-hidden sm:rounded-3xl border border-gray-100">

        <!-- Notifikasi Sesi (Sukses/Status) -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Hero Text -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selamat Datang Kembali</h1>
            <p class="mt-2 text-md text-gray-500">Akses akun Anda dengan mengisi detail di bawah.</p>
        </div>

        <!-- Form Start -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Alamat Email')" class="font-bold text-gray-700 mb-1" />
                <x-text-input 
                    id="email" 
                    {{-- Kelas mode gelap tambahan untuk memastikan input tetap terang --}}
                    class="block w-full bg-gray-50 text-gray-900 border-gray-300 focus:border-indigo-600 focus:ring-indigo-600 focus:ring-opacity-50 rounded-xl shadow-inner-sm transition duration-300 p-3 
                           dark:bg-gray-50 dark:text-gray-900 dark:border-gray-300 dark:focus:border-indigo-600" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="nama.anda@contoh.com"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Kata Sandi')" class="font-bold text-gray-700 mb-1" />
                <x-text-input 
                    id="password" 
                    {{-- Kelas mode gelap tambahan untuk memastikan input tetap terang --}}
                    class="block w-full bg-gray-50 text-gray-900 border-gray-300 focus:border-indigo-600 focus:ring-indigo-600 focus:ring-opacity-50 rounded-xl shadow-inner-sm transition duration-300 p-3
                           dark:bg-gray-50 dark:text-gray-900 dark:border-gray-300 dark:focus:border-indigo-600"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password" 
                    placeholder="••••••••"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password Group -->
            <div class="flex items-center justify-between pt-2">
                
                <!-- Remember Me -->
                <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-600 transition duration-150" name="remember">
                    <span class="ms-2 text-sm text-gray-700 group-hover:text-gray-900 transition duration-150">{{ __('Ingat Saya') }}</span>
                </label>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition duration-150" href="{{ route('password.request') }}">
                        {{ __('Lupa Kata Sandi?') }}
                    </a>
                @endif
            </div>

            <!-- Tombol Log in -->
            <div class="mt-8">
                <button 
                    type="submit" 
                    class="w-full flex items-center justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-lg font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50 transition duration-300 transform hover:scale-[1.005]"
                >
                    {{ __('Masuk') }}
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-4a3 3 0 013-3h7"></path></svg>
                </button>
            </div>
            
            <!-- Link Pendaftaran (Register) -->
            @if (Route::has('register'))
            <div class="pt-4 text-center text-sm text-gray-600 border-t border-gray-200 mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-700 transition duration-150 ml-1">{{ __('Daftar sekarang') }}</a>
            </div>
            @endif

        </form>
        <!-- Form End -->

    </div>
</x-guest-layout>
