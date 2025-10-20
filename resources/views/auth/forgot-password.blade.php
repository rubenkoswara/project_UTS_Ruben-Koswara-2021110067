<x-guest-layout>
    {{-- Container utama form diubah menjadi kartu yang menawan --}}
    <div class="p-6 bg-white shadow-2xl rounded-2xl border border-gray-100 transform transition duration-500 hover:shadow-indigo-300/50">

        {{-- Judul dan Deskripsi --}}
        <h2 class="text-3xl font-extrabold text-indigo-700 mb-2 text-center">
            Lupa Kata Sandi?
        </h2>
        <div class="mb-6 text-sm text-gray-700 text-center border-b pb-4">
            {{ __('Lupakan kata sandi Anda? Santai. Cukup masukkan alamat email Anda dan kami akan mengirimkan tautan reset kata sandi.') }}
        </div>

        <!-- Session Status (Pemberitahuan setelah email terkirim) -->
        <x-auth-session-status class="mb-4 text-green-600 font-semibold" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="space-y-1">
                <x-input-label for="email" :value="__('Alamat Email')" class="text-gray-900 font-semibold" />
                
                {{-- Menggunakan komponen x-text-input kita yang sudah Light Mode --}}
                <x-text-input 
                    id="email" 
                    class="block w-full" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    placeholder="Masukkan email Anda di sini"
                />
                
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-center mt-6">
                {{-- Menggunakan primary-button dengan efek hover yang lebih menonjol --}}
                <button type="submit" class="w-full px-4 py-3 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                    {{ __('Kirim Tautan Reset Kata Sandi') }}
                </button>
            </div>
            
            {{-- Tambahan link kembali ke halaman login --}}
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-800 transition duration-150 ease-in-out">
                    &#x2190; Kembali ke Halaman Login
                </a>
            </div>
            
        </form>
    </div>
</x-guest-layout>
