<x-guest-layout>
    {{-- Container utama form diubah menjadi kartu yang menawan --}}
    <div class="p-6 bg-white shadow-2xl rounded-2xl border border-gray-100 transform transition duration-500 hover:shadow-indigo-300/50">

        {{-- Judul dan Deskripsi --}}
        <h2 class="text-3xl font-extrabold text-indigo-700 mb-2 text-center">
            Atur Ulang Kata Sandi
        </h2>
        <div class="mb-6 text-sm text-gray-700 text-center border-b pb-4">
            {{ __('Silakan masukkan alamat email Anda, kata sandi baru, dan konfirmasi kata sandi untuk menyelesaikan proses reset.') }}
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="space-y-1">
                <x-input-label for="email" :value="__('Alamat Email')" class="text-gray-900 font-semibold" />
                <x-text-input 
                    id="email" 
                    class="block w-full" 
                    type="email" 
                    name="email" 
                    :value="old('email', $request->email)" 
                    required 
                    autofocus 
                    autocomplete="username" 
                    placeholder="Contoh: user@domain.com"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4 space-y-1">
                <x-input-label for="password" :value="__('Kata Sandi Baru')" class="text-gray-900 font-semibold" />
                <x-text-input 
                    id="password" 
                    class="block w-full" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="new-password" 
                    placeholder="Masukkan kata sandi baru Anda"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4 space-y-1">
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="text-gray-900 font-semibold" />
                <x-text-input 
                    id="password_confirmation" 
                    class="block w-full"
                    type="password"
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password" 
                    placeholder="Ulangi kata sandi baru Anda"
                />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-center mt-6">
                {{-- Menggunakan primary-button dengan efek hover yang lebih menonjol --}}
                <button type="submit" class="w-full px-4 py-3 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                    {{ __('Atur Ulang Kata Sandi') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
