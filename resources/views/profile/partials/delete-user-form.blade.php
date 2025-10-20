<section class="space-y-6">
    <header>
        {{-- MENGGUNAKAN INLINE STYLE UNTUK MEMAKSA WARNA HITAM PEKAT (#000000) --}}
        <h2 class="text-lg font-medium" style="color: #000000 !important;">
            {{ __('Delete Account') }}
        </h2>

        {{-- MENGGUNAKAN INLINE STYLE UNTUK MEMAKSA WARNA HITAM PEKAT (#000000) --}}
        <p class="mt-1 text-sm" style="color: #000000 !important;">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        {{-- SOLUSI PALING AGRESIF UNTUK MODAL BODY --}}
        <form 
            method="post" 
            action="{{ route('profile.destroy') }}" 
            class="p-6 rounded-lg shadow-xl" 
            style="background-color: white !important;"
        >
            @csrf
            @method('delete')

            {{-- JUDUL MODAL: PAKSA HITAM PEKAT --}}
            <h2 class="text-lg font-medium" style="color: #000000 !important;">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            {{-- DESKRIPSI MODAL: PAKSA HITAM PEKAT --}}
            <p class="mt-1 text-sm" style="color: #000000 !important;">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                {{-- LABEL INPUT PASSWORD: PAKSA HITAM PEKAT --}}
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" style="color: #000000 !important;" />

                {{-- **SOLUSI INPUT PALING AGRESIF** --}}
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    {{-- Hapus kelas Tailwind bg/text dan ganti dengan inline style !important --}}
                    class="mt-1 block w-3/4 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    style="background-color: white !important; color: #000000 !important;"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
