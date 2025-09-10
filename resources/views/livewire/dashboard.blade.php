<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if(!$taxProfile)
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-8">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    No tax profile found. Please contact support.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $this->getTinStatusBadgeClass($taxProfile->tin_status ?? 'not_requested') }}">
                            {{ $this->getTinStatusLabel($taxProfile->tin_status ?? 'not_requested') }}
                        </span>
                    </div>
                    
                    <!-- TIN Status Card -->
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-8">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h.01a1 1 0 100-2H10V9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                @if($taxProfile->tin_status === 'approved')
                                    <p class="text-sm text-blue-700">
                                        Your TIN Number: <span class="font-bold">{{ $taxProfile->tin_number }}</span>
                                    </p>
                                    <p class="text-sm text-blue-700 mt-1">
                                        Approved on: {{ $taxProfile->tin_approved_at?->format('F j, Y') }}
                                    </p>
                                @elseif($taxProfile->tin_status === 'pending')
                                    <p class="text-sm text-blue-700">
                                        Your TIN request is currently under review. You will be notified once it's approved.
                                    </p>
                                    <p class="text-sm text-blue-700 mt-1">
                                        Requested on: {{ $taxProfile->tin_requested_at?->format('F j, Y') }}
                                    </p>
                                @else
                                    <p class="text-sm text-blue-700">
                                        You haven't requested a TIN number yet. Click the button above to submit your request.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Full Name</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Phone</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->phone ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Country</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $taxProfile->country ?? 'Not specified' }}</p>
                            </div>
                            @if($taxProfile->nid_number)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">NID Number</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $taxProfile->nid_number }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    @if($taxProfile->tin_status === 'approved')
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <a href="#" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">File Tax Return</p>
                                            <p class="text-sm text-gray-500">Submit your tax return for the current year</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">Make a Payment</p>
                                            <p class="text-sm text-gray-500">Pay your tax dues online</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">View Documents</p>
                                            <p class="text-sm text-gray-500">Access your tax documents and certificates</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
