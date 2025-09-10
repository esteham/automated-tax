<div class="bg-white p-6 rounded-lg shadow-md max-w-3xl mx-auto">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Request for TIN Number</h2>
        <p class="text-gray-600">Please provide your National ID details to request a TIN number</p>
        
        @if (session()->has('message'))
            <div class="mt-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif
        
        @error('form_error')
            <div class="mt-4 p-3 bg-red-100 text-red-700 rounded">
                {{ $message }}
            </div>
        @enderror
    </div>

    <form wire:submit.prevent="submitRequest" class="space-y-6">
        <!-- NID Information -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">National ID Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- NID Number -->
                <div class="col-span-2">
                    <label for="nid_number" class="block text-sm font-medium text-gray-700">NID Number <span class="text-red-500">*</span></label>
                    <input type="text" id="nid_number" wire:model.live="nid_number" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nid_number') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('nid_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Issuing Country -->
                <div>
                    <label for="nid_issuing_country" class="block text-sm font-medium text-gray-700">Issuing Country <span class="text-red-500">*</span></label>
                    <select id="nid_issuing_country" wire:model.live="nid_issuing_country" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nid_issuing_country') border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
                        <option value="">Select Country</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="United States">United States</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="Canada">Canada</option>
                        <option value="Australia">Australia</option>
                    </select>
                    @error('nid_issuing_country')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Issue Date -->
                <div>
                    <label for="nid_issue_date" class="block text-sm font-medium text-gray-700">Issue Date <span class="text-red-500">*</span></label>
                    <input type="date" id="nid_issue_date" wire:model.live="nid_issue_date" max="{{ now()->format('Y-m-d') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nid_issue_date') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('nid_issue_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expiry Date -->
                <div>
                    <label for="nid_expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date <span class="text-red-500">*</span></label>
                    <input type="date" id="nid_expiry_date" wire:model.live="nid_expiry_date" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nid_expiry_date') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('nid_expiry_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Security PIN Verification -->
        <div class="bg-blue-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Security Verification</h3>
            
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="security_pin" class="block text-sm font-medium text-gray-700">Enter Your 4-Digit Security PIN <span class="text-red-500">*</span></label>
                    <input type="password" id="security_pin" wire:model.live="security_pin" 
                           class="mt-1 block w-1/2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('security_pin') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                           maxlength="4" inputmode="numeric" pattern="\d{4}">
                    @error('security_pin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">For security reasons, please enter the 4-digit PIN you created during registration.</p>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end mt-6">
            <a href="{{ route('dashboard') }}" class="mr-4 text-sm font-medium text-gray-600 hover:text-gray-900">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                Submit TIN Request
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        // Set minimum expiry date based on issue date
        Livewire.on('nid_issue_date', (date) => {
            const expiryDateInput = document.getElementById('nid_expiry_date');
            if (date && expiryDateInput) {
                expiryDateInput.min = date;
                if (expiryDateInput.value && new Date(expiryDateInput.value) < new Date(date)) {
                    expiryDateInput.value = '';
                    @this.set('nid_expiry_date', null);
                }
            }
        });
    });
</script>
@endpush
