<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">TIN Registration</h2>
        <p class="text-gray-600">Create your taxpayer account</p>
        
        @if (session()->has('message'))
            <div class="mt-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif
        
        @error('registration_error')
            <div class="mt-4 p-3 bg-red-100 text-red-700 rounded">
                {{ $message }}
            </div>
        @enderror
    </div>

    <form wire:submit.prevent="register" class="space-y-4">
        <!-- Error Summary -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            There {{ $errors->count() === 1 ? 'is' : 'are' }} {{ $errors->count() }} {{ Str::plural('error', $errors->count()) }} with your submission
                        </h3>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Username -->
            <div class="col-span-2">
                <label for="username" class="block text-sm font-medium text-gray-700">Username <span class="text-red-500">*</span></label>
                <input type="text" id="username" wire:model.live="username" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('username') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                       autofocus>
                @error('username')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Security PIN -->
            <div class="col-span-2">
                <label for="security_pin" class="block text-sm font-medium text-gray-700">Security PIN (4 digits) <span class="text-red-500">*</span></label>
                <input type="password" id="security_pin" wire:model.live="security_pin" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('security_pin') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                       maxlength="4" inputmode="numeric" pattern="\d{4}">
                @error('security_pin')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Security PIN -->
            <div class="col-span-2">
                <label for="security_pin_confirmation" class="block text-sm font-medium text-gray-700">Confirm Security PIN <span class="text-red-500">*</span></label>
                <input type="password" id="security_pin_confirmation" wire:model.live="security_pin_confirmation" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       maxlength="4" inputmode="numeric" pattern="\d{4}">
            </div>

            <!-- Email -->
            <div class="col-span-2">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
                <input type="email" id="email" wire:model.live="email" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Country -->
            <div class="col-span-2 md:col-span-1">
                <label for="country" class="block text-sm font-medium text-gray-700">Country <span class="text-red-500">*</span></label>
                <select id="country" wire:model.live="country" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('country') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
                    <option value="">Select a country</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="United States">United States</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="Canada">Canada</option>
                    <option value="Australia">Australia</option>
                </select>
                @error('country')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone Number -->
            <div class="col-span-2 md:col-span-1">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number <span class="text-red-500">*</span></label>
                <input type="tel" id="phone" wire:model.live="phone" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('phone') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="col-span-2 md:col-span-1">
                <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                <input type="password" id="password" wire:model.live="password" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="col-span-2 md:col-span-1">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password <span class="text-red-500">*</span></label>
                <input type="password" id="password_confirmation" wire:model.live="password_confirmation" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="mt-4">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="terms" type="checkbox" wire:model.live="terms" 
                           class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 @error('terms') border-red-300 text-red-900 focus:ring-red-500 @enderror">
                </div>
                <div class="ml-3 text-sm">
                    <label for="terms" class="font-medium text-gray-700">I agree to the <a href="#" class="text-blue-600 hover:text-blue-500">Terms and Conditions</a></label>
                    @error('terms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50">
                <span wire:loading.remove>Register</span>
                <span wire:loading>Processing...</span>
            </button>
        </div>
    </form>

    <div class="mt-4 text-center text-sm text-gray-600">
        Already have an account? 
        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
            Sign in
        </a>
    </div>
</div>
