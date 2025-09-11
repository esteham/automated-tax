<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('TIN Information Dashboard') }}
            </h2>
            <div class="flex space-x-4">
                @if($taxProfile?->tin_certificate_path)
                    <x-primary-button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700">
                        {{ __('Print TIN Certificate') }}
                    </x-primary-button>
                @endif
                <x-secondary-link :href="route('profile.edit')">
                    {{ __('Update Profile') }}
                </x-secondary-link>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- TIN Information Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Taxpayer Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">TIN Number</h4>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $taxProfile->tin_number ?? 'Not Available' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Full Name</h4>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Email Address</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ auth()->user()->email }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Registration Date</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $taxProfile->created_at?->format('F j, Y') ?? 'N/A' }}</p>
                        </div>
                        @if($taxProfile?->nid_number)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">National ID</h4>
                                <p class="mt-1 text-lg text-gray-900">{{ $taxProfile->nid_number }}</p>
                            </div>
                        @endif
                        @if($taxProfile?->tin_issue_date)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">TIN Issue Date</h4>
                                <p class="mt-1 text-lg text-gray-900">{{ $taxProfile->tin_issue_date->format('F j, Y') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('tax.returns.create') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">File Tax Return</h3>
                            <p class="mt-1 text-sm text-gray-500">Submit your tax return for the current period</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('tax.returns.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">View Returns</h3>
                            <p class="mt-1 text-sm text-gray-500">Check your tax return history and status</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Account Settings</h3>
                            <p class="mt-1 text-sm text-gray-500">Update your profile and security settings</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Recent Activity -->
            @if(isset($taxProfile->activities) && $taxProfile->activities->isNotEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                        <div class="space-y-4">
                            @foreach($taxProfile->activities->take(5) as $activity)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">{{ $activity->description ?? 'Activity' }}</p>
                                        <p class="text-sm text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
