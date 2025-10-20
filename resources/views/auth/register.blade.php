{{-- Light Mode Penuh: Card Putih, Input Putih, Teks Gelap --}}

<x-guest-layout>
    {{-- Container utama: Light Mode Card (Putih) --}}
    <div class="p-8 bg-white shadow-2xl rounded-2xl w-full max-w-md mx-auto border border-gray-100 transition-all duration-300 hover:shadow-3xl">
        
        {{-- Header: Ikon Petir dan Teks Sapaan --}}
        <div class="text-center mb-6">
            {{-- Ikon Petir (Warna Indigo) --}}
            <svg class="w-10 h-10 text-indigo-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            
            {{-- Judul Form menjadi Hitam (text-gray-900) --}}
            <h1 class="text-2xl font-bold text-gray-900 mb-1">Daftar Akun Baru</h1>
            <p class="text-sm text-gray-500">Isi detail Anda untuk membuat akun.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- GRID UNTUK FIELD INPUT --}}
            <div class="grid grid-cols-1 gap-4">
                
                <!-- Name -->
                <div>
                    {{-- Label Teks Gelap --}}
                    <x-input-label for="name" :value="__('Name')" class="text-gray-700" />
                    {{-- Input: Light Mode Style (BG Putih, Teks Hitam) --}}
                    <x-text-input id="name" class="block mt-1 w-full border-gray-300 bg-white text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-150" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Anda" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                    {{-- Input: Light Mode Style (BG Putih, Teks Hitam) --}}
                    <x-text-input id="email" class="block mt-1 w-full border-gray-300 bg-white text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-150" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="alamat.email@contoh.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Baris 3: Handphone dan Tanggal Lahir (Dua Kolom) --}}
                <div class="grid grid-cols-2 gap-4">
                    <!-- Nomor Handphone (Optional) -->
                    <div>
                        <x-input-label for="phone_number" :value="__('No. Handphone')" class="text-gray-700" />
                        {{-- Input: Light Mode Style --}}
                        <x-text-input id="phone_number" class="block mt-1 w-full border-gray-300 bg-white text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-150" type="text" name="phone_number" :value="old('phone_number')" autocomplete="tel" placeholder="08xxxxxxxxxx" />
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                    </div>

                    <!-- Tanggal Lahir (Optional) -->
                    <div>
                        <x-input-label for="date_of_birth" :value="__('Tanggal Lahir')" class="text-gray-700" />
                        {{-- Input: Light Mode Style --}}
                        <x-text-input id="date_of_birth" class="block mt-1 w-full border-gray-300 bg-white text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-150" type="date" name="date_of_birth" :value="old('date_of_birth')" autocomplete="bday" placeholder="dd/mm/yyyy" />
                        <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                    </div>
                </div>

                <!-- Alamat (Optional - Menggunakan textarea) -->
                <div>
                    <x-input-label for="address" :value="__('Alamat Lengkap')" class="text-gray-700" />
                    {{-- Textarea: Light Mode Style --}}
                    <textarea id="address" 
                        class="border-gray-300 bg-white text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full transition-all duration-150" 
                        name="address"
                        placeholder="Jl. Contoh No. 123"
                    >{{ old('address') }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
                
                {{-- Baris 5: Password (Dua Kolom) --}}
                <div class="grid grid-cols-2 gap-4">
                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                        {{-- Input: Light Mode Style --}}
                        <x-text-input id="password" class="block mt-1 w-full border-gray-300 bg-white text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-150"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Minimal 8 Karakter" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700" />
                        {{-- Input: Light Mode Style --}}
                        <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 bg-white text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-150"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi Password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

            </div>
            {{-- AKHIR GRID --}}

            {{-- Footer Aksi --}}
            <div class="mt-6">
                {{-- Tombol dengan warna Indigo (Biru) --}}
                <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 text-white font-semibold py-2 rounded-lg transition duration-150 shadow-md hover:shadow-lg">
                    {{ __('REGISTER') }}
                </x-primary-button>
            </div>
            
            <div class="text-center mt-4">
                 <a class="text-sm text-gray-500 hover:text-gray-700 underline" href="{{ route('login') }}">
                    {{ __('Already registered?') }} <span class="font-semibold text-indigo-600 hover:text-indigo-700">Login</span>
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
