<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Auditor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-5 mt-6 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Total Audits -->
                <div class="p-5 transition-shadow border rounded-lg shadow-sm hover:shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-3xl font-semibold">{{ number_format($totalAudits) }}</span>
                            <span class="text-gray-500">Total Audits</span>
                        </div>
                        <div class="p-3 rounded-full bg-indigo-50">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all audits</a>
                    </div>
                </div>

                <!-- Pending Reviews -->
                <div class="p-5 transition-shadow border rounded-lg shadow-sm hover:shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-3xl font-semibold">{{ number_format($pendingReviews) }}</span>
                            <span class="text-gray-500">Pending Reviews</span>
                        </div>
                        <div class="p-3 rounded-full bg-yellow-50">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Review now</a>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="p-5 transition-shadow border rounded-lg shadow-sm hover:shadow">
                    <div class="flex flex-col">
                        <span class="text-lg font-semibold">Quick Actions</span>
                        <div class="grid grid-cols-2 gap-2 mt-2">
                            <a href="#" class="px-3 py-2 text-sm text-center text-white bg-indigo-600 rounded hover:bg-indigo-700">Start Audit</a>
                            <a href="#" class="px-3 py-2 text-sm text-center text-gray-700 bg-gray-200 rounded hover:bg-gray-300">Generate Report</a>
                            <a href="#" class="px-3 py-2 text-sm text-center text-gray-700 bg-gray-200 rounded hover:bg-gray-300">View Calendar</a>
                            <a href="#" class="px-3 py-2 text-sm text-center text-gray-700 bg-gray-200 rounded hover:bg-gray-300">Audit Logs</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Audits -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Recent Audits</h3>
                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-900">View all audits</a>
                </div>
                
                @if($recentAudits->count() > 0)
                    <div class="overflow-hidden bg-white shadow sm:rounded-md">
                        <ul class="divide-y divide-gray-200">
                            @foreach($recentAudits as $audit)
                                <li>
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="text-sm font-medium text-indigo-600 truncate">
                                                Audit #{{ $audit->id }}
                                            </div>
                                            <div class="flex-shrink-0 ml-2">
                                                @if($audit->status === 'completed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Completed
                                                    </span>
                                                @elseif($audit->status === 'in_progress')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        In Progress
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Pending
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-2 sm:flex sm:justify-between">
                                            <div class="sm:flex">
                                                <p class="flex items-center text-sm text-gray-500">
                                                    {{ $audit->taxpayer->name ?? 'N/A' }}
                                                </p>
                                            </div>
                                            <div class="flex items-center mt-2 text-sm text-gray-500 sm:mt-0">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                                </svg>
                                                <p>
                                                    {{ $audit->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="p-8 text-center bg-white rounded-lg shadow">
                        <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No audit records</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new audit.</p>
                        <div class="mt-6">
                            <a href="#" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                New Audit
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-dashboard-layout>
