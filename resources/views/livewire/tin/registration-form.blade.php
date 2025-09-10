<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">TIN Registration</h2>
        <p class="text-gray-600">Create your taxpayer account</p>
    </div>

    <form wire:submit.prevent="register">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Username -->
            <div class="col-span-2">
                <label for="username" class="block text-sm font-medium text-gray-700">Username <span class="text-red-500">*</span></label>
                <input type="text" id="username" wire:model="username" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       required autofocus>
                @error('username') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- TIN Number -->
            <div class="col-span-2">
                <label for="tin_number" class="block text-sm font-medium text-gray-700">TIN Number <span class="text-red-500">*</span></label>
                <input type="text" id="tin_number" wire:model="tin_number" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       required>
                @error('tin_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div class="col-span-2">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
                <input type="email" id="email" wire:model="email" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       required>
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Country -->
            <div class="col-span-2 md:col-span-1">
                <label for="country" class="block text-sm font-medium text-gray-700">Country <span class="text-red-500">*</span></label>
                <select id="country" wire:model="country" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="United States">United States</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="Canada">Canada</option>
                    <option value="Australia">Australia</option>
                </select>
                @error('country') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Phone Number -->
            <div class="col-span-2 md:col-span-1">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number <span class="text-red-500">*</span></label>
                <input type="tel" id="phone" wire:model="phone" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       required>
                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div class="col-span-2 md:col-span-1">
                <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                <input type="password" id="password" wire:model="password" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       required>
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Confirm Password -->
            <div class="col-span-2 md:col-span-1">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password <span class="text-red-500">*</span></label>
                <input type="password" id="password_confirmation" wire:model="password_confirmation" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       required>
            </div>
        </div>

        <div class="mt-6 flex items-center">
            <input id="terms" name="terms" type="checkbox" required
                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <label for="terms" class="ml-2 block text-sm text-gray-700">
                I agree to the <a href="#" class="text-blue-600 hover:text-blue-500">Terms and Conditions</a>
            </label>
        </div>

        <div class="mt-6">
            <button type="submit" 
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Register
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
