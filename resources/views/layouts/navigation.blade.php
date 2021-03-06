<nav x-data="{ open: false }" class="bg-blue-600 border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-full flex flex-col mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-white" />
                    </a>
                </div>                                                                      
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-white hover:text-yellow-300 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Logout') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-yellow-200 hover:bg-white focus:outline-none focus:bg-gray-100 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="flex h-16 justify-end bg-blue-900 px-4 sm:px-6 lg:px-8">

        <!-- Navigation Links -->
        {{-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-lg text-white">
                {{ __('T???ng quan') }}
            </x-nav-link>
        </div> --}}

        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link :href="route('orders')" :active="request()->routeIs('orders')">
                {{ __('????n h??ng') }}
            </x-nav-link>
        </div> 
        @if(auth()->user()->user_type === 'admin')
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link :href="route('products')" :active="request()->routeIs('products')">
                    {{ __('S???n ph???m') }}
                </x-nav-link>
            </div> 

            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link :href="route('attributes')" :active="request()->routeIs('attributes')">
                    {{ __('Thu???c t??nh') }}
                </x-nav-link>
            </div>  

            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link :href="route('machines')" :active="request()->routeIs('machines')">
                    {{ __('M??y s???n xu???t') }}
                </x-nav-link>
            </div> 

            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link :href="route('menu')" :active="request()->routeIs('menu')">
                    {{ __('Menu') }}
                </x-nav-link>
            </div> 
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link :href="route('banners')" :active="request()->routeIs('banners')">
                    {{ __('Banner') }}
                </x-nav-link>
            </div> 
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link :href="route('pages')" :active="request()->routeIs('pages')">
                    {{ __('Trang') }}
                </x-nav-link>
            </div>      
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link :href="route('users')" :active="request()->routeIs('users')">
                    {{ __('Ng?????i d??ng') }}
                </x-nav-link>
            </div>    
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link :href="route('settings')" :active="request()->routeIs('settings')">
                    {{ __('C??i ?????t') }}
                </x-nav-link>
            </div>  
        @endif
    </div>    

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            {{-- <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('T???ng quan') }}
            </x-responsive-nav-link> --}}

            <x-responsive-nav-link :href="route('orders')" :active="request()->routeIs('orders')">
                {{ __('????n h??ng') }}
            </x-responsive-nav-link>
            @if(auth()->user()->user_type === 'admin')
                <x-responsive-nav-link :href="route('products')" :active="request()->routeIs('products')">
                    {{ __('S???n ph???m') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('attributes')" :active="request()->routeIs('attributes')">
                    {{ __('Thu???c t??nh') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('machines')" :active="request()->routeIs('machines')">
                    {{ __('M??y s???n xu???t') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('menu')" :active="request()->routeIs('menu')">
                    {{ __('Menu') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('banners')" :active="request()->routeIs('banners')">
                    {{ __('Banner') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('pages')" :active="request()->routeIs('pages')">
                    {{ __('Trang') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('users')" :active="request()->routeIs('users')">
                    {{ __('Ng?????i d??ng') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('settings')" :active="request()->routeIs('settings')">
                    {{ __('C??i ?????t') }}
                </x-responsive-nav-link>          
            @endif  
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <svg class="h-10 w-10 fill-current text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>

                <div class="ml-3">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-white">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Logout') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
