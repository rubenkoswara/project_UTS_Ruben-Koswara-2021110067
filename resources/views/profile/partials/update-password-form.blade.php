<section>
    <header>
        {{-- MENGGUNAKAN INLINE STYLE UNTUK MEMAKSA WARNA HITAM PEKAT (#000000) --}}
        <h2 class="text-lg font-medium" style="color: #000000 !important;">
            {{ __('Update Password') }}
        </h2>

        {{-- MENGGUNAKAN INLINE STYLE UNTUK MEMAKSA WARNA HITAM PEKAT (#000000) --}}
        <p class="mt-1 text-sm" style="color: #000000 !important;">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- Field: Current Password (Light Mode) --}}
        <div>
            {{-- Label diatur ke Hitam Pekat (#000000) MENGGUNAKAN INLINE STYLE --}}
            <x-input-label for="update_password_current_password" :value="__('Current Password')" style="color: #000000 !important;" />
            
            {{-- Input dengan kelas Light Mode eksplisit: bg-white dan text-gray-900 --}}
            <input id="update_password_current_password" name="current_password" type="password" 
                   class="mt-1 block w-full border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                   autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- Field: New Password (Light Mode) --}}
        <div>
            {{-- Label diatur ke Hitam Pekat (#000000) MENGGUNAKAN INLINE STYLE --}}
            <x-input-label for="update_password_password" :value="__('New Password')" style="color: #000000 !important;" />
            
            {{-- Input dengan kelas Light Mode eksplisit: bg-white dan text-gray-900 --}}
            <input id="update_password_password" name="password" type="password" 
                   class="mt-1 block w-full border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                   autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- Field: Confirm Password (Light Mode) --}}
        <div>
            {{-- Label diatur ke Hitam Pekat (#000000) MENGGUNAKAN INLINE STYLE --}}
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" style="color: #000000 !important;" />
            
            {{-- Input dengan kelas Light Mode eksplisit: bg-white dan text-gray-900 --}}
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                   class="mt-1 block w-full border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                   autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
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
