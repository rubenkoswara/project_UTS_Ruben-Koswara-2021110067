<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-700 transition duration-150 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('customer.home') }}"> 
                        {{-- Logo dengan warna terang --}}
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div>

                {{-- Link Navigasi Utama (Teks Putih, Hover Indigo) --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('customer.home')" :active="request()->routeIs('customer.home')" 
                        class="text-white font-medium hover:text-indigo-400 border-transparent hover:border-indigo-400 transition duration-150">
                        {{ __('Katalog') }}
                    </x-nav-link>
                    
                    @auth
                    <x-nav-link :href="route('customer.orders')" :active="request()->routeIs('customer.orders')"
                        class="text-white font-medium hover:text-indigo-400 border-transparent hover:border-indigo-400 transition duration-150">
                        {{ __('Pesanan Saya') }}
                    </x-nav-link>
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                
                {{-- TOMBOL DASHBOARD ADMIN (Gaya Flat dan Elegan) --}}
                @auth 
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" 
                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-semibold rounded-md text-white bg-indigo-600 hover:bg-indigo-500 transition duration-300 ease-in-out mr-4 shadow-md">
                            Dashboard Admin &rarr;
                        </a>
                    @endif
                @endauth
                
                {{-- KODE HANYA MUNCUL JIKA SUDAH LOGIN (Dropdown) --}}
                @auth 
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-200 bg-gray-800 hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div> 

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth 
                
                {{-- KODE HANYA MUNCUL JIKA BELUM LOGIN (Login/Register Link) --}}
                @guest
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white font-medium transition duration-150">
                        {{ __('Login') }}
                    </a>
                    <a href="{{ route('register') }}" class="text-white bg-indigo-600 px-3 py-2 rounded-md hover:bg-indigo-500 font-semibold transition duration-150">
                        {{ __('Register') }}
                    </a>
                </div>
                @endguest
            </div>

            {{-- Responsive Menu Button (Hamburger) --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Responsive Navigation --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-700">
        {{-- Responsive Links --}}
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('customer.home')" :active="request()->routeIs('customer.home')" class="text-white hover:bg-gray-600">
                {{ __('Katalog') }}
            </x-responsive-nav-link>
            @auth
            <x-responsive-nav-link :href="route('customer.orders')" :active="request()->routeIs('customer.orders')" class="text-white hover:bg-gray-600">
                {{ __('Pesanan Saya') }}
            </x-responsive-nav-link>
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-gray-600">
            {{-- KODE HANYA MUNCUL JIKA SUDAH LOGIN --}}
            @auth 
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                {{-- LINK ADMIN RESPONSIVE --}}
                @if (auth()->user()->is_admin)
                <x-responsive-nav-link :href="route('admin.dashboard')" class="bg-indigo-700 text-white">
                    {{ __('Dashboard Admin') }}
                </x-responsive-nav-link>
                @endif
                
                <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-200 hover:bg-gray-600">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-gray-200 hover:bg-gray-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @else
            {{-- KODE HANYA MUNCUL JIKA BELUM LOGIN (Responsive) --}}
            <div class="pt-2 pb-3 space-y-1 px-4">
                <x-responsive-nav-link :href="route('login')" class="text-white hover:bg-gray-600">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" class="text-white hover:bg-gray-600">
                    {{ __('Register') }}
                </x-responsive-nav-link>
            </div>
            @endauth
        </div>
    </div>
</nav>
