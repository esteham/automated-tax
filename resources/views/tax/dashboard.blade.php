@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Tax Dashboard</h1>
        @if(auth()->user()->hasCompletedProfile())
            <a href="{{ route('tax.returns.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                File New Return
            </a>
        @endif
    </div>

    @if(!auth()->user()->hasCompletedProfile())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
            <p class="font-bold">Profile Incomplete</p>
            <p>Please complete your profile before filing a tax return.</p>
            <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:text-blue-800 underline">Complete Profile</a>
        </div>
    @endif

    <!-- Current Year Return Status -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">{{ now()->format('Y') }} Tax Return</h2>
        
        @if(isset($currentReturn))
            <div class="bg-green-50 border border-green-200 rounded p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-medium text-green-800">Return Filed</h3>
                        <p class="text-sm text-green-600">
                            Submitted on {{ $currentReturn->submitted_at->format('F j, Y') }}
                            • Status: <span class="font-medium">{{ ucfirst($currentReturn->status) }}</span>
                        </p>
                    </div>
                    <a href="{{ route('tax.returns.show', $currentReturn) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        View Details →
                    </a>
                </div>
            </div>
        @else
            <div class="bg-blue-50 border border-blue-200 rounded p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-medium text-blue-800">No Return Filed Yet</h3>
                        <p class="text-sm text-blue-600">You haven't filed a tax return for {{ now()->format('Y') }} yet.</p>
                    </div>
                    @if(auth()->user()->hasCompletedProfile())
                        <a href="{{ route('tax.returns.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                            File Now
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Recent Returns -->
    @if($recentReturns->isNotEmpty())
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Recent Returns</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Taxable Income</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tax Amount</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentReturns as $return)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $return->filing_year }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ ucfirst($return->filing_type) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'draft' => 'bg-yellow-100 text-yellow-800',
                                            'submitted' => 'bg-blue-100 text-blue-800',
                                            'processing' => 'bg-purple-100 text-purple-800',
                                            'approved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                        ];
                                        $color = $statusColors[$return->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                        {{ ucfirst($return->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ৳{{ number_format($return->taxable_income, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ৳{{ number_format($return->tax_amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('tax.returns.show', $return) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
