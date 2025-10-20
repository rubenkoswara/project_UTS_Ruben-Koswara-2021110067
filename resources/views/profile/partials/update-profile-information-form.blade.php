<section>
    <header>
        {{-- MENGGUNAKAN INLINE STYLE UNTUK MEMAKSA WARNA HITAM PEKAT (#000000) --}}
        <h2 class="text-lg font-medium" style="color: #000000 !important;">
            {{ __('Profile Information') }}
        </h2>

        {{-- MENGGUNAKAN INLINE STYLE UNTUK MEMAKSA WARNA HITAM PEKAT (#000000) --}}
        <p class="mt-1 text-sm" style="color: #000000 !important;">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Field: Nama (Light Mode) --}}
        <div>
            {{-- Label diatur ke Hitam Pekat (#000000) MENGGUNAKAN INLINE STYLE --}}
            <x-input-label for="name" :value="__('Name')" style="color: #000000 !important;" />
            <input id="name" name="name" type="text" 
                   class="mt-1 block w-full border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                   value="{{ old('name', $user->name) }}" 
                   required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Field: Email (Light Mode) --}}
        <div>
            {{-- Label diatur ke Hitam Pekat (#000000) MENGGUNAKAN INLINE STYLE --}}
            <x-input-label for="email" :value="__('Email')" style="color: #000000 !important;" />
            <input id="email" name="email" type="email" 
                   class="mt-1 block w-full border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                   value="{{ old('email', $user->email) }}" 
                   required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    {{-- Teks status verifikasi diatur ke Hitam Pekat (#000000) MENGGUNAKAN INLINE STYLE --}}
                    <p class="text-sm mt-2 text-gray-800" style="color: #000000 !important;">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        
        {{-- Field BARU: Nomor Handphone (Light Mode) --}}
        <div>
            {{-- Label diatur ke Hitam Pekat (#000000) MENGGUNAKAN INLINE STYLE --}}
            <x-input-label for="phone_number" :value="__('No. Handphone')" style="color: #000000 !important;" />
            <input id="phone_number" name="phone_number" type="text" 
                   class="mt-1 block w-full border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                   value="{{ old('phone_number', $user->phone_number ?? '') }}" 
                   autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        {{-- Field BARU: Tanggal Lahir (Light Mode) --}}
        <div>
            {{-- Label diatur ke Hitam Pekat (#000000) MENGGUNAKAN INLINE STYLE --}}
            <x-input-label for="date_of_birth" :value="__('Tanggal Lahir')" style="color: #000000 !important;" />
            <input id="date_of_birth" name="date_of_birth" type="date" 
                   class="mt-1 block w-full border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                   value="{{ old('date_of_birth', $user->date_of_birth ?? '') }}" 
                   autocomplete="bday" />
            <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
        </div>

        {{-- Field BARU: Alamat (Light Mode) --}}
        <div>
            {{-- Label diatur ke Hitam Pekat (#000000) MENGGUNAKAN INLINE STYLE --}}
            <x-input-label for="address" :value="__('Alamat Lengkap')" style="color: #000000 !important;" />
            <textarea id="address" name="address" class="border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">{{ old('address', $user->address ?? '') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    {{-- Mengatur teks status ke warna abu-abu (Light Mode) --}}
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
