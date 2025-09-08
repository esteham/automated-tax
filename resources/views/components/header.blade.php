<!-- Header Component -->
<header>
    <!-- Navigation -->
    <nav class="navbar fixed w-full z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-primary flex items-center">
                <!-- <i class="fas fa-calculator text-primary mr-2"></i> -->
                {{ config('app.name', 'Automated Tax System') }}
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#services" class="text-gray-700 hover:text-primary transition-colors">Services</a>
                <a href="#how-it-works" class="text-gray-700 hover:text-primary transition-colors">How It Works</a>
                <a href="#tax-calculator" class="text-gray-700 hover:text-primary transition-colors">Calculator</a>
                
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary transition-colors">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="text-gray-700 hover:text-primary focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="mobile-menu hidden md:hidden bg-white shadow-lg rounded-lg mt-2 py-2 mx-4">
            <a href="#services" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Services</a>
            <a href="#how-it-works" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">How It Works</a>
            <a href="#tax-calculator" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Calculator</a>
            
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>
</header>
