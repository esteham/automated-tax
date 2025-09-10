<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Request TIN Number</h2>
                
                @if($submitted)
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    Your TIN request has been submitted successfully and is under review.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Return to Dashboard
                        </a>
                    </div>
                @else
                    <form wire:submit.prevent="submitRequest" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- NID Number -->
                            <div class="col-span-1">
                                <label for="nid_number" class="block text-sm font-medium text-gray-700">NID Number <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       id="nid_number" 
                                       wire:model="nid_number" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('nid_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- NID Front Image -->
                            <div class="col-span-1">
                                <label for="nid_front_image" class="block text-sm font-medium text-gray-700">NID Front Side <span class="text-red-500">*</span></label>
                                <input type="file" 
                                       id="nid_front_image" 
                                       wire:model="nid_front_image" 
                                       accept="image/*" 
                                       class="mt-1 block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-md file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-blue-50 file:text-blue-700
                                              hover:file:bg-blue-100">
                                @error('nid_front_image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @if($nid_front_image)
                                    <div class="mt-2">
                                        <img src="{{ $nid_front_image->temporaryUrl() }}" alt="NID Front Preview" class="h-32 w-auto object-cover rounded">
                                    </div>
                                @endif
                            </div>
                            
                            <!-- NID Back Image -->
                            <div class="col-span-1">
                                <label for="nid_back_image" class="block text-sm font-medium text-gray-700">NID Back Side <span class="text-red-500">*</span></label>
                                <input type="file" 
                                       id="nid_back_image" 
                                       wire:model="nid_back_image" 
                                       accept="image/*" 
                                       class="mt-1 block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-md file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-blue-50 file:text-blue-700
                                              hover:file:bg-blue-100">
                                @error('nid_back_image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @if($nid_back_image)
                                    <div class="mt-2">
                                        <img src="{{ $nid_back_image->temporaryUrl() }}" alt="NID Back Preview" class="h-32 w-auto object-cover rounded">
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="pt-5">
                            <div class="flex justify-end">
                                <a href="{{ route('dashboard') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Cancel
                                </a>
                                <button type="submit" 
                                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Submit Request
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
