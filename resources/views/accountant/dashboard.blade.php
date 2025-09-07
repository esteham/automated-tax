<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Accountant Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-5 mt-6 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Pending Filings -->
                <div class="p-5 transition-shadow border rounded-lg shadow-sm hover:shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-3xl font-semibold">{{ $pendingFilings }}</span>
                            <span class="text-gray-500">Pending Filings</span>
                        </div>
                        <div class="p-3 rounded-full bg-yellow-50">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all pending filings</a>
                    </div>
                </div>

                <!-- Total Tax Collected -->
                <div class="p-5 transition-shadow border rounded-lg shadow-sm hover:shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-3xl font-semibold">${{ number_format($totalTaxCollected, 2) }}</span>
                            <span class="text-gray-500">Total Tax Collected</span>
                        </div>
                        <div class="p-3 rounded-full bg-green-50">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View financial reports</a>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="p-5 transition-shadow border rounded-lg shadow-sm hover:shadow">
                    <div class="flex flex-col">
                        <span class="text-lg font-semibold">Quick Actions</span>
                        <div class="grid grid-cols-2 gap-2 mt-2">
                            <a href="#" class="px-3 py-2 text-sm text-center text-white bg-indigo-600 rounded hover:bg-indigo-700">Record Payment</a>
                            <a href="#" class="px-3 py-2 text-sm text-center text-gray-700 bg-gray-200 rounded hover:bg-gray-300">Generate Report</a>
                            <a href="#" class="px-3 py-2 text-sm text-center text-gray-700 bg-gray-200 rounded hover:bg-gray-300">View Calendar</a>
                            <a href="#" class="px-3 py-2 text-sm text-center text-gray-700 bg-gray-200 rounded hover:bg-gray-300">Send Reminders</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Payments -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Recent Payments</h3>
                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-900">View all payments</a>
                </div>
                
                @if($recentPayments->count() > 0)
                    <div class="overflow-hidden bg-white shadow sm:rounded-md">
                        <ul class="divide-y divide-gray-200">
                            @foreach($recentPayments as $payment)
                                <li>
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="text-sm font-medium text-indigo-600 truncate">
                                                Payment #{{ $payment->id }}
                                            </div>
                                            <div class="flex-shrink-0 ml-2">
                                                <p class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                                    ${{ number_format($payment->amount, 2) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-2 sm:flex sm:justify-between">
                                            <div class="sm:flex">
                                                <p class="flex items-center text-sm text-gray-500">
                                                    {{ $payment->taxpayer->name ?? 'N/A' }}
                                                </p>
                                            </div>
                                            <div class="flex items-center mt-2 text-sm text-gray-500 sm:mt-0">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                                </svg>
                                                <p>
                                                    {{ $payment->created_at->diffForHumans() }}
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No payments</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by recording a new payment.</p>
                        <div class="mt-6">
                            <a href="#" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                New Payment
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-dashboard-layout>
