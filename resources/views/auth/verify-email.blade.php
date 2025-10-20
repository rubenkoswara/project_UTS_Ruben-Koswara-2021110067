<x-guest-layout>
    {{-- Container utama form diubah menjadi kartu yang menawan --}}
    <div class="p-6 bg-white shadow-2xl rounded-2xl border border-gray-100 transform transition duration-500 hover:shadow-indigo-300/50">

        {{-- Judul dan Deskripsi --}}
        <h2 class="text-3xl font-extrabold text-indigo-700 mb-4 text-center">
            Verifikasi Diperlukan
        </h2>

        {{-- Pesan Utama --}}
        <div class="mb-6 text-base text-gray-700 leading-relaxed text-center">
            {{ __('Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan ke email Anda?') }}
            <br><br>
            {{ __('Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkannya lagi.') }}
        </div>

        {{-- Status Notifikasi Email Terkirim --}}
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 p-3 bg-green-100 border border-green-300 rounded-lg font-medium text-sm text-green-700 text-center">
                {{ __('Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat pendaftaran.') }}
            </div>
        @endif

        {{-- Area Tombol --}}
        <div class="mt-6 space-y-3">
            
            {{-- Tombol 1: Kirim Ulang Verifikasi --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="w-full justify-center">
                    {{ __('Kirim Ulang Email Verifikasi') }}
                </x-primary-button>
            </form>

            {{-- Tombol 2: Keluar --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-center py-2 text-sm font-semibold text-gray-600 hover:text-indigo-700 transition duration-150 ease-in-out rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Keluar (Log Out)') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
