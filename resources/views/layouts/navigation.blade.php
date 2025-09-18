<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- TIN Requests Link -->
                    <x-nav-link :href="route('tin-requests.index')" :active="request()->routeIs('tin-requests.*')">
                        {{ __('My TIN Requests') }}
                    </x-nav-link>
                    
                    @if(!auth()->user()->taxProfile?->tin_number)
                        <!-- Request New TIN Link -->
                        <x-nav-link :href="route('tin-requests.create')" :active="request()->routeIs('tin-requests.create')">
                            {{ __('Apply for TIN') }}
                        </x-nav-link>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Admin Dashboard') }}
                        </x-nav-link>
                        
                        <!-- TIN Requests Management with Badge -->
                        <x-nav-link :href="route('admin.tin-requests.index')" :active="request()->routeIs('admin.tin-requests.*')">
                            <div class="flex items-center">
                                <span>{{ __('Manage TIN Requests') }}</span>
                                @if($pendingTinRequestsCount > 0)
                                    <span class="inline-flex items-center justify-center px-2 py-0.5 ms-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                                        {{ $pendingTinRequestsCount }}
                                    </span>
                                @endif
                            </div>
                        </x-nav-link>
                    @endif
                    
                    @if(auth()->user()->hasRole('auditor'))
                        <!-- TIN Requests Management for Auditors with Badge -->
                        <x-nav-link :href="route('tin-requests.index')" :active="request()->routeIs('tin-requests.*')">
                            <div class="flex items-center">
                                <span>{{ __('Review TIN Requests') }}</span>
                                @if($pendingTinRequestsCount > 0)
                                    <span class="inline-flex items-center justify-center px-2 py-0.5 ms-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                                        {{ $pendingTinRequestsCount }}
                                    </span>
                                @endif
                            </div>
                        </x-nav-link>
                        
                        <x-nav-link :href="route('auditor.dashboard')" :active="request()->routeIs('auditor.*')">
                            {{ __('Auditor Panel') }}
                        </x-nav-link>
                    @endif

                    @if(auth()->user()->hasRole('accountant'))
                        <x-nav-link :href="route('accountant.dashboard')" :active="request()->routeIs('accountant.*')">
                            {{ __('Accountant Panel') }}
                        </x-nav-link>
                    @endif

                    @can('filing.create')
                        <x-nav-link :href="route('taxpayers.create')" :active="request()->routeIs('taxpayers.create')">
                            {{ __('New Tax Filing') }}
                        </x-nav-link>
                    @endcan
                    
                    <!-- Tax Navigation Links -->
                    @auth
                        <x-nav-link :href="route('tax.dashboard')" :active="request()->routeIs('tax.*')">
                            {{ __('My Tax Returns') }}
                        </x-nav-link>
                        
                        @can('file-return')
                            <x-nav-link :href="route('tax.returns.create')" :active="request()->routeIs('tax.returns.create')">
                                {{ __('File New Return') }}
                            </x-nav-link>
                        @endcan
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
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

                        <!-- Request TIN Link -->
                        <x-dropdown-link :href="route('tin.request')">
                            {{ __('Request TIN') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
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
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(auth()->user()->taxProfile?->tin_number)
                <!-- TIN Information Link -->
                <x-responsive-nav-link :href="route('tin.dashboard')" :active="request()->routeIs('tin.*')">
                    {{ __('TIN Information') }}
                </x-responsive-nav-link>
            @else
                <!-- Request TIN Link -->
                <x-responsive-nav-link :href="route('tin.request')" :active="request()->routeIs('tin.request')">
                    {{ __('Request TIN') }}
                </x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasRole('admin'))
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Admin Dashboard') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('admin.tin-requests.index')" :active="request()->routeIs('admin.tin-requests.*')">
                    <div class="flex items-center">
                        <span>{{ __('Manage TIN Requests') }}</span>
                        @if($pendingTinRequestsCount > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 ms-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                                {{ $pendingTinRequestsCount }}
                            </span>
                        @endif
                    </div>
                </x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasRole('accountant'))
                <x-responsive-nav-link :href="route('accountant.dashboard')" :active="request()->routeIs('accountant.*')">
                    {{ __('Accountant Panel') }}
                </x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasRole('auditor'))
                <x-responsive-nav-link :href="route('auditor.dashboard')" :active="request()->routeIs('auditor.*')">
                    {{ __('Auditor Panel') }}
                </x-responsive-nav-link>
            @endif

            @can('filing.create')
                <x-responsive-nav-link :href="route('taxpayers.create')" :active="request()->routeIs('taxpayers.create')">
                    {{ __('New Tax Filing') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Request TIN Link -->
                <x-responsive-nav-link :href="route('tin.request')">
                    {{ __('Request TIN') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
