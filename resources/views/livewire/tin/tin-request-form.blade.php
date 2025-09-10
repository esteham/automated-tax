<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    TIN Number Request
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Please provide your National ID (NID) information to request a TIN number.
                </p>
            </div>

            @if (session('message'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 m-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                {{ session('message') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 m-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <form wire:submit.prevent="submitRequest" class="px-4 py-5 sm:p-6">
                <div class="space-y-6">
                    <!-- NID Number -->
                    <div>
                        <label for="nid_number" class="block text-sm font-medium text-gray-700">NID Number</label>
                        <input type="text" wire:model="nid_number" id="nid_number" autocomplete="off"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('nid_number') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <!-- NID Issue Date -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nid_issue_date" class="block text-sm font-medium text-gray-700">NID Issue Date</label>
                            <input type="date" wire:model="nid_issue_date" id="nid_issue_date"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('nid_issue_date') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- NID Expiry Date -->
                        <div>
                            <label for="nid_expiry_date" class="block text-sm font-medium text-gray-700">NID Expiry Date</label>
                            <input type="date" wire:model="nid_expiry_date" id="nid_expiry_date"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('nid_expiry_date') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- NID Front Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NID Front Side</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="nid_front_image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input id="nid_front_image" name="nid_front_image" type="file" class="sr-only" wire:model="nid_front_image">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, JPEG up to 2MB
                                </p>
                            </div>
                        </div>
                        @error('nid_front_image') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                        @if($nid_front_image)
                            <p class="mt-2 text-sm text-gray-600">
                                Selected: {{ $nid_front_image->getClientOriginalName() }}
                            </p>
                        @endif
                    </div>

                    <!-- NID Back Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NID Back Side</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="nid_back_image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input id="nid_back_image" name="nid_back_image" type="file" class="sr-only" wire:model="nid_back_image">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, JPEG up to 2MB
                                </p>
                            </div>
                        </div>
                        @error('nid_back_image') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                        @if($nid_back_image)
                            <p class="mt-2 text-sm text-gray-600">
                                Selected: {{ $nid_back_image->getClientOriginalName() }}
                            </p>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Submit Request
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
