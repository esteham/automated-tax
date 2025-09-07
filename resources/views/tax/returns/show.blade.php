@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tax Return for {{ $taxReturn->filing_year }}</h1>
            <div class="flex items-center mt-2">
                @php
                    $statusColors = [
                        'draft' => 'bg-yellow-100 text-yellow-800',
                        'submitted' => 'bg-blue-100 text-blue-800',
                        'processing' => 'bg-purple-100 text-purple-800',
                        'approved' => 'bg-green-100 text-green-800',
                        'rejected' => 'bg-red-100 text-red-800',
                    ];
                    $color = $statusColors[$taxReturn->status] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $color }}">
                    {{ ucfirst($taxReturn->status) }}
                </span>
                @if($taxReturn->submitted_at)
                    <span class="ml-2 text-sm text-gray-600">
                        Submitted on {{ $taxReturn->submitted_at->format('F j, Y') }}
                    </span>
                @endif
            </div>
        </div>
        
        <div class="mt-4 md:mt-0 flex space-x-2">
            <a href="{{ route('tax.dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Back to Dashboard
            </a>
            @if($taxReturn->status === 'draft')
                <a href="{{ route('tax.returns.edit', $taxReturn) }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Edit Return
                </a>
            @endif
            <button onclick="window.print()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Print
            </button>
            @if($canPay)
                <a href="#payment" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                    Pay Now
                </a>
            @endif
        </div>
    </div>

    <!-- Return Summary -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Return Summary</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 border rounded-lg">
                <h3 class="text-sm font-medium text-gray-500">Total Income</h3>
                <p class="mt-1 text-2xl font-semibold text-gray-900">৳{{ number_format($taxReturn->total_income, 2) }}</p>
            </div>
            
            <div class="p-4 border rounded-lg">
                <h3 class="text-sm font-medium text-gray-500">Total Exemptions</h3>
                <p class="mt-1 text-2xl font-semibold text-gray-900">৳{{ number_format($taxReturn->taxable_income - $taxReturn->total_income, 2) }}</p>
            </div>
            
            <div class="p-4 border rounded-lg bg-blue-50">
                <h3 class="text-sm font-medium text-blue-700">Taxable Income</h3>
                <p class="mt-1 text-2xl font-semibold text-blue-900">৳{{ number_format($taxReturn->taxable_income, 2) }}</p>
            </div>
            
            <div class="p-4 border rounded-lg bg-indigo-50">
                <h3 class="text-sm font-medium text-indigo-700">Tax Payable</h3>
                <p class="mt-1 text-2xl font-semibold text-indigo-900">৳{{ number_format($taxReturn->tax_amount, 2) }}</p>
            </div>
            
            <div class="p-4 border rounded-lg bg-green-50">
                <h3 class="text-sm font-medium text-green-700">Amount Paid</h3>
                <p class="mt-1 text-2xl font-semibold text-green-900">৳{{ number_format($taxReturn->paid_amount, 2) }}</p>
            </div>
            
            <div class="p-4 border rounded-lg bg-amber-50">
                <h3 class="text-sm font-medium text-amber-700">Balance Due</h3>
                <p class="mt-1 text-2xl font-semibold text-amber-900">৳{{ number_format(max(0, $taxReturn->tax_amount - $taxReturn->paid_amount), 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Income Sources -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Income Sources</h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Source Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount (BDT)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($taxReturn->incomeSources as $source)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ ucfirst($source->source_type) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $source->source_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                ৳{{ number_format($source->amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                No income sources found.
                            </td>
                        </tr>
                    @endforelse
                    <tr class="bg-gray-50">
                        <td colspan="2" class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                            Total Income:
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                            ৳{{ number_format($taxReturn->incomeSources->sum('amount'), 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Exemptions & Deductions -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Exemptions & Deductions</h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount (BDT)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($taxReturn->exemptions as $exemption)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ ucfirst(str_replace('_', ' ', $exemption->exemption_type)) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $exemption->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                ৳{{ number_format($exemption->amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                No exemptions or deductions claimed.
                            </td>
                        </tr>
                    @endforelse
                    @if($taxReturn->exemptions->isNotEmpty())
                        <tr class="bg-gray-50">
                            <td colspan="2" class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                                Total Exemptions:
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                                ৳{{ number_format($taxReturn->exemptions->sum('amount'), 2) }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tax Calculation -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Tax Calculation</h2>
        
        <div class="max-w-md mx-auto">
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Income:</span>
                    <span class="font-medium">৳{{ number_format($taxReturn->total_income, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Less: Total Exemptions:</span>
                    <span class="font-medium">-৳{{ number_format($taxReturn->total_income - $taxReturn->taxable_income, 2) }}</span>
                </div>
                <div class="border-t border-gray-200 my-2"></div>
                <div class="flex justify-between font-medium">
                    <span>Taxable Income:</span>
                    <span>৳{{ number_format($taxReturn->taxable_income, 2) }}</span>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="flex justify-between text-lg font-semibold">
                        <span>Tax Payable:</span>
                        <span class="text-blue-600">৳{{ number_format($taxReturn->tax_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment History -->
    @if($taxReturn->payments->isNotEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Payment History</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount (BDT)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($taxReturn->payments as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->created_at->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ ucfirst($payment->payment_method) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->transaction_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                    ৳{{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            'failed' => 'bg-red-100 text-red-800',
                                            'refunded' => 'bg-purple-100 text-purple-800',
                                        ];
                                        $color = $statusColors[$payment->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Payment Section -->
    @if($canPay)
        <div id="payment" class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Make a Payment</h2>
            
            <div class="max-w-2xl mx-auto">
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h2a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Your tax amount of <span class="font-bold">৳{{ number_format($taxReturn->tax_amount - $taxReturn->paid_amount, 2) }}</span> is due. Please select a payment method below to complete your payment.
                            </p>
                        </div>
                    </div>
                </div>
                
                <form action="#" method="POST" id="paymentForm">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="payment-method-option">
                                <input type="radio" name="payment_method" value="bkash" class="sr-only" checked>
                                <div class="p-4 border rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('images/bkash-logo.png') }}" alt="bKash" class="h-8">
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">bKash</p>
                                            <p class="text-xs text-gray-500">Pay with your bKash account</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="payment-method-option">
                                <input type="radio" name="payment_method" value="nagad" class="sr-only">
                                <div class="p-4 border rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('images/nagad-logo.png') }}" alt="Nagad" class="h-8">
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Nagad</p>
                                            <p class="text-xs text-gray-500">Pay with your Nagad account</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="payment-method-option">
                                <input type="radio" name="payment_method" value="bank" class="sr-only">
                                <div class="p-4 border rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3.9 6.5M12 3v16m0 0l4-4m-4 4l-4-4m4 4l4-4m-4-4l-4 4m4-4l4 4"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Bank Transfer</p>
                                            <p class="text-xs text-gray-500">Make a bank transfer</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="payment-method-option">
                                <input type="radio" name="payment_method" value="card" class="sr-only">
                                <div class="p-4 border rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-1-5h1m4 0h1m-9 5h1m-1-5h1m-1 5h1m-1-5h1m-1 5h1m-1-5h1m-1 5h1m-1-5h1m-1 5h1m-1-5h1m-1 5h1m-1-5h1m-1 5h1m-1-5h1m-1 5h1m-1-5h1m-1 5h1m-1-5h1m-1 5h1m-1-5h1m-1 5h1"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Credit/Debit Card</p>
                                            <p class="text-xs text-gray-500">Pay with Visa, Mastercard, etc.</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-3 text-right sm:px-6 rounded-b-lg">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Pay ৳{{ number_format($taxReturn->tax_amount - $taxReturn->paid_amount, 2) }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    
    <!-- Return Status & Actions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Return Status & Actions</h2>
        
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-900">Return Details</h3>
                    <div class="mt-1 text-sm text-gray-600">
                        <p>Return ID: {{ $taxReturn->id }}</p>
                        <p>Filing Type: {{ ucfirst($taxReturn->filing_type) }}</p>
                        <p>Tax Year: {{ $taxReturn->filing_year }}</p>
                    </div>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-900">Payment Status</h3>
                    <div class="mt-1 text-sm text-gray-600">
                        @if($taxReturn->tax_amount <= $taxReturn->paid_amount)
                            <p>Fully Paid</p>
                        @elseif($taxReturn->paid_amount > 0)
                            <p>Partially Paid (৳{{ number_format($taxReturn->paid_amount, 2) }} of ৳{{ number_format($taxReturn->tax_amount, 2) }})</p>
                        @else
                            <p>Payment Pending</p>
                        @endif
                    </div>
                </div>
            </div>
            
            @if($taxReturn->status === 'draft')
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-900">Action Required</h3>
                        <div class="mt-1 text-sm text-gray-600">
                            <p>This return is still in draft status. Please submit it for processing.</p>
                        </div>
                        <div class="mt-2
                        <form action="{{ route('tax.returns.submit', $taxReturn) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Submit Return
                            </button>
                        </form>
                    </div>
                </div>
            @endif
            
            @if($taxReturn->status === 'submitted' && $taxReturn->tax_amount > $taxReturn->paid_amount)
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-900">Payment Due</h3>
                        <div class="mt-1 text-sm text-gray-600">
                            <p>Your tax payment of ৳{{ number_format($taxReturn->tax_amount - $taxReturn->paid_amount, 2) }} is due.</p>
                        </div>
                        <div class="mt-2">
                            <a href="#payment" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Make Payment
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #print-section, #print-section * {
            visibility: visible;
        }
        #print-section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle print functionality
        document.querySelectorAll('.print-btn').forEach(button => {
            button.addEventListener('click', function() {
                window.print();
            });
        });
        
        // Handle payment method selection
        document.querySelectorAll('.payment-method-option input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.payment-method-option').forEach(option => {
                    option.querySelector('div').classList.remove('border-blue-500', 'bg-blue-50');
                });
                
                if (this.checked) {
                    this.closest('label').querySelector('div').classList.add('border-blue-500', 'bg-blue-50');
                }
            });
            
            // Trigger change on page load for the checked radio
            if (radio.checked) {
                radio.dispatchEvent(new Event('change'));
            }
        });
        
        // Handle form submission
        const paymentForm = document.getElementById('paymentForm');
        if (paymentForm) {
            paymentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const paymentMethod = formData.get('payment_method');
                
                // In a real app, you would handle the payment processing here
                // For now, we'll just show an alert
                alert(`Processing ${paymentMethod} payment...`);
                
                // Simulate a successful payment after a delay
                setTimeout(() => {
                    // In a real app, you would submit the form to your payment processing endpoint
                    // and handle the response to update the UI accordingly
                    alert('Payment processed successfully!');
                    window.location.reload();
                }, 4000);
            });
        }
    });
</script>
@endpush
@endsection
