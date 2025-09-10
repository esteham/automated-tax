<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-gray-800">Tax Portal</a>
            </div>
            <div class="flex items-center space-x-4">
                @if(isset($taxProfile) && is_object($taxProfile) && $taxProfile->tin_status !== 'approved')
                    <a href="{{ route('tin.request') }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium">
                        @if($taxProfile->tin_status === 'pending')
                            View TIN Request
                        @else
                            Request TIN Number
                        @endif
                    </a>
                @endif
                
                <!-- Profile dropdown -->
                <div class="ml-3 relative">
                    <div class="flex items-center">
                        <span class="text-gray-700 text-sm mr-2">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-gray-900 text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
