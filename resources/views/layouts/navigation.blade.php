<nav x-data="{ open: false }" class="bg-gray-900 border-b border-teal-500/30 shadow-2xl shadow-teal-500/10 transition duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:lg-8">
        <div class="flex justify-between h-16">
            
            <div class="flex items-center">
                <a href="{{ route('shop.index') }}" class="flex items-center space-x-2">
                    
                    <div class="relative w-10 h-10 flex items-center justify-center rounded-full bg-teal-600 border-2 border-yellow-400 p-1 shadow-lg shadow-teal-500/50">
                        <span class="text-2xl" role="img" aria-label="Ikan">🐠</span> 
                    </div>
                    
                    <span class="text-xl font-extrabold text-white tracking-wider">Renesca Aquatic</span>
                </a>
            </div>

            <div class="hidden sm:flex sm:flex-grow sm:justify-center sm:items-center">
                <div class="space-x-8">
                    <x-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.index')" 
                        class="text-gray-300 font-medium hover:text-teal-400 border-transparent hover:border-teal-400 transition duration-200">
                        {{ __('Katalog') }}
                    </x-nav-link>
                    
                    @auth
                    <x-nav-link :href="route('shop.myOrders')" :active="request()->routeIs('shop.myOrders')"
                        class="text-gray-300 font-medium hover:text-teal-400 border-transparent hover:border-teal-400 transition duration-200">
                        {{ __('Pesanan Saya') }}
                    </x-nav-link>
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                
                @auth
                {{-- PERBAIKAN: Mengganti route('shop.cart') dengan route('shop.viewCart') --}}
                <a href="{{ route('shop.viewCart') }}" class="mr-4 p-2 text-gray-300 hover:text-white transition duration-150 rounded-full hover:bg-gray-800" title="Keranjang Belanja">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </a>
                @endauth
                
                @auth 
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" 
                           class="inline-flex items-center px-4 py-2 border-2 border-teal-500 text-sm font-bold rounded-full text-teal-400 bg-gray-900 hover:bg-teal-500 hover:text-gray-900 transition duration-300 ease-in-out mr-4">
                            Dashboard Admin 
                        </a>
                    @endif
                @endauth
                
                @auth 
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-gray-700 text-sm leading-4 font-medium rounded-full text-gray-200 bg-gray-800 hover:text-white focus:outline-none transition ease-in-out duration-150 shadow-md">
                            <div class="font-bold">{{ Auth::user()->name }}</div> 

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-gray-800 hover:bg-teal-50 hover:text-teal-600">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-gray-800 hover:bg-red-50 hover:text-red-600">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth 
                
                @guest
                <div class="space-x-3">
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-teal-400 font-medium transition duration-150 px-3 py-2 rounded-md">
                        {{ __('Login') }}
                    </a>
                    <a href="{{ route('register') }}" class="text-gray-900 bg-teal-400 px-4 py-2 rounded-full hover:bg-teal-300 font-bold transition duration-150 shadow-lg shadow-teal-500/50">
                        {{ __('Register') }}
                    </a>
                </div>
                @endguest
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-800 focus:outline-none focus:bg-gray-800 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-800 border-t border-gray-700">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('shop.orders')" :active="request()->routeIs('shop.orders')" class="text-white hover:bg-gray-700">
                {{ __('Katalog') }}
            </x-responsive-nav-link>
            @auth
            <x-responsive-nav-link :href="route('shop.orders')" :active="request()->routeIs('shop.orders')" class="text-white hover:bg-gray-700">
                {{ __('Pesanan Saya') }}
            </x-responsive-nav-link>
            @endauth
            
            @auth
                @if (auth()->user()->is_admin)
                <x-responsive-nav-link :href="route('admin.dashboard')" class="bg-teal-700 text-white hover:bg-teal-600 font-bold mt-2">
                    {{ __('Dashboard Admin') }}
                </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-gray-700">
            @auth 
            <div class="px-4">
                <div class="font-bold text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-200 hover:bg-gray-700">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                     this.closest('form').submit();" class="text-gray-200 hover:bg-red-700 hover:text-white">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @else
            <div class="pt-2 pb-3 space-y-1 px-4">
                <a href="{{ route('login') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white hover:text-gray-200 hover:bg-gray-700 hover:border-gray-600 focus:outline-none focus:text-white focus:bg-gray-700 focus:border-gray-600 transition duration-150 ease-in-out">
                    {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium bg-teal-600 text-white hover:bg-teal-500 focus:outline-none focus:bg-teal-500 transition duration-150 ease-in-out">
                    {{ __('Register') }}
                </a>
            </div>
            @endguest
        </div>
    </div>
</nav>
