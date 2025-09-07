@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Tax Return</h1>
        <p class="text-gray-600">For the tax year {{ $taxReturn->filing_year }}</p>
    </div>

    <form action="{{ route('tax.returns.update', $taxReturn) }}" method="POST" id="taxReturnForm">
        @csrf
        @method('PUT')
        
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="filing_type" class="block text-sm font-medium text-gray-700 mb-1">Filing Type</label>
                    <select name="filing_type" id="filing_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="individual" {{ old('filing_type', $taxReturn->filing_type) === 'individual' ? 'selected' : '' }}>Individual</option>
                        <option value="business" {{ old('filing_type', $taxReturn->filing_type) === 'business' ? 'selected' : '' }}>Business</option>
                        <option value="freelancer" {{ old('filing_type', $taxReturn->filing_type) === 'freelancer' ? 'selected' : '' }}>Freelancer</option>
                    </select>
                    @error('filing_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="filing_year" class="block text-sm font-medium text-gray-700 mb-1">Tax Year</label>
                    <input type="text" id="filing_year" name="filing_year" value="{{ old('filing_year', $taxReturn->filing_year) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-100" readonly>
                    @error('filing_year')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Income Sources -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Income Sources</h2>
                <button type="button" id="addIncomeSource" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    + Add Income Source
                </button>
            </div>
            
            <div id="incomeSourcesContainer">
                <!-- Income source template (hidden) -->
                <div class="income-source-template hidden mb-4 p-4 border border-gray-200 rounded-md">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <div class="md:col-span-4">
                            <select name="income_sources[0][source_type]" class="source-type w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="salary">Salary</option>
                                <option value="business">Business Income</option>
                                <option value="rental">Rental Income</option>
                                <option value="interest">Interest Income</option>
                                <option value="dividend">Dividend Income</option>
                                <option value="other">Other Income</option>
                            </select>
                        </div>
                        <div class="md:col-span-5">
                            <input type="text" name="income_sources[0][source_name]" placeholder="Source name (e.g., Company Name)" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">৳</span>
                                </div>
                                <input type="number" name="income_sources[0][amount]" placeholder="0.00" step="0.01" min="0" 
                                       class="amount-input block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                        <div class="md:col-span-1 flex items-center justify-end">
                            <button type="button" class="text-red-600 hover:text-red-800 remove-income-source">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Existing income sources -->
                @foreach($taxReturn->incomeSources as $index => $source)
                    <div class="income-source mb-4 p-4 border border-gray-200 rounded-md">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                            <div class="md:col-span-4">
                                <select name="income_sources[{{ $index }}][source_type]" class="source-type w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="salary" {{ $source->source_type === 'salary' ? 'selected' : '' }}>Salary</option>
                                    <option value="business" {{ $source->source_type === 'business' ? 'selected' : '' }}>Business Income</option>
                                    <option value="rental" {{ $source->source_type === 'rental' ? 'selected' : '' }}>Rental Income</option>
                                    <option value="interest" {{ $source->source_type === 'interest' ? 'selected' : '' }}>Interest Income</option>
                                    <option value="dividend" {{ $source->source_type === 'dividend' ? 'selected' : '' }}>Dividend Income</option>
                                    <option value="other" {{ $source->source_type === 'other' ? 'selected' : '' }}>Other Income</option>
                                </select>
                            </div>
                            <div class="md:col-span-5">
                                <input type="text" name="income_sources[{{ $index }}][source_name]" 
                                       value="{{ old('income_sources.'.$index.'.source_name', $source->source_name) }}" 
                                       placeholder="Source name (e.g., Company Name)" 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <div class="md:col-span-2">
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">৳</span>
                                    </div>
                                    <input type="number" name="income_sources[{{ $index }}][amount]" 
                                           value="{{ old('income_sources.'.$index.'.amount', $source->amount) }}" 
                                           placeholder="0.00" step="0.01" min="0" 
                                           class="amount-input block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500" required>
                                </div>
                            </div>
                            <div class="md:col-span-1 flex items-center justify-end">
                                <button type="button" class="text-red-600 hover:text-red-800 remove-income-source">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-4 p-4 bg-gray-50 rounded-md">
                <div class="flex justify-between">
                    <span class="font-medium">Total Income:</span>
                    <span id="totalIncome" class="font-bold">৳{{ number_format($taxReturn->incomeSources->sum('amount'), 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Exemptions -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Exemptions & Deductions</h2>
                <button type="button" id="addExemption" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    + Add Exemption
                </button>
            </div>
            
            <div id="exemptionsContainer">
                <!-- Exemption template (hidden) -->
                <div class="exemption-template hidden mb-4 p-4 border border-gray-200 rounded-md">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <div class="md:col-span-4">
                            <select name="exemptions[0][exemption_type]" class="exemption-type w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @foreach(\App\Models\TaxExemptionType::active()->get() as $type)
                                    <option value="{{ $type->code }}" data-max-amount="{{ $type->max_amount }}">
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-5">
                            <input type="text" name="exemptions[0][description]" placeholder="Description" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">৳</span>
                                </div>
                                <input type="number" name="exemptions[0][amount]" placeholder="0.00" step="0.01" min="0" 
                                       class="amount-input block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">max: <span class="max-amount">-</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="md:col-span-1 flex items-center justify-end">
                            <button type="button" class="text-red-600 hover:text-red-800 remove-exemption">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Existing exemptions -->
                @foreach($taxReturn->exemptions as $index => $exemption)
                    @php
                        $exemptionType = \App\Models\TaxExemptionType::where('code', $exemption->exemption_type)->first();
                        $maxAmount = $exemptionType ? $exemptionType->max_amount : null;
                    @endphp
                    <div class="exemption mb-4 p-4 border border-gray-200 rounded-md">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                            <div class="md:col-span-4">
                                <select name="exemptions[{{ $index }}][exemption_type]" class="exemption-type w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    @foreach(\App\Models\TaxExemptionType::active()->get() as $type)
                                        <option value="{{ $type->code }}" 
                                                data-max-amount="{{ $type->max_amount }}"
                                                {{ $exemption->exemption_type === $type->code ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-5">
                                <input type="text" name="exemptions[{{ $index }}][description]" 
                                       value="{{ old('exemptions.'.$index.'.description', $exemption->description) }}" 
                                       placeholder="Description" 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <div class="md:col-span-2">
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">৳</span>
                                    </div>
                                    <input type="number" name="exemptions[{{ $index }}][amount]" 
                                           value="{{ old('exemptions.'.$index.'.amount', $exemption->amount) }}" 
                                           placeholder="0.00" step="0.01" min="0" 
                                           class="amount-input block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500" required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">max: <span class="max-amount">{{ $maxAmount ? '৳' . number_format($maxAmount, 2) : '∞' }}</span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="md:col-span-1 flex items-center justify-end">
                                <button type="button" class="text-red-600 hover:text-red-800 remove-exemption">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-4 p-4 bg-gray-50 rounded-md">
                <div class="flex justify-between">
                    <span class="font-medium">Total Exemptions:</span>
                    <span id="totalExemptions" class="font-bold">৳{{ number_format($taxReturn->exemptions->sum('amount'), 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Tax Calculation Preview -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Tax Calculation</h2>
            
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span>Total Income:</span>
                    <span id="previewTotalIncome">৳{{ number_format($taxReturn->incomeSources->sum('amount'), 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Total Exemptions:</span>
                    <span id="previewTotalExemptions">-৳{{ number_format($taxReturn->exemptions->sum('amount'), 2) }}</span>
                </div>
                <div class="border-t border-gray-200 my-2"></div>
                <div class="flex justify-between font-medium">
                    <span>Taxable Income:</span>
                    <span id="previewTaxableIncome">৳{{ number_format($taxReturn->taxable_income, 2) }}</span>
                </div>
                <div class="flex justify-between font-medium text-lg mt-4">
                    <span>Estimated Tax:</span>
                    <span id="previewTaxAmount" class="text-blue-600">৳{{ number_format($taxReturn->tax_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-between">
            <a href="{{ route('tax.returns.show', $taxReturn) }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Cancel
            </a>
            <div class="space-x-2">
                <button type="submit" name="action" value="save_draft" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Save as Draft
                </button>
                <button type="submit" name="action" value="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Return
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Income Sources
        const incomeSourcesContainer = document.getElementById('incomeSourcesContainer');
        const addIncomeSourceBtn = document.getElementById('addIncomeSource');
        
        // Exemptions
        const exemptionsContainer = document.getElementById('exemptionsContainer');
        const addExemptionBtn = document.getElementById('addExemption');
        
        // Add income source
        addIncomeSourceBtn.addEventListener('click', function() {
            const template = document.querySelector('.income-source-template').cloneNode(true);
            template.classList.remove('hidden', 'income-source-template');
            
            // Update index in name attributes
            const index = document.querySelectorAll('.income-source:not(.template)').length;
            template.querySelectorAll('[name^="income_sources["]').forEach(input => {
                const name = input.getAttribute('name').replace(/\[\d+\]/, `[${index}]`);
                input.setAttribute('name', name);
            });
            
            // Add remove functionality
            const removeBtn = template.querySelector('.remove-income-source');
            removeBtn.addEventListener('click', function() {
                template.remove();
                calculateTotals();
            });
            
            // Add amount change listener
            const amountInput = template.querySelector('.amount-input');
            amountInput.addEventListener('input', calculateTotals);
            
            incomeSourcesContainer.appendChild(template);
            calculateTotals();
        });
        
        // Add exemption
        addExemptionBtn.addEventListener('click', function() {
            const template = document.querySelector('.exemption-template').cloneNode(true);
            template.classList.remove('hidden', 'exemption-template');
            
            // Update index in name attributes
            const index = document.querySelectorAll('.exemption:not(.template)').length;
            template.querySelectorAll('[name^="exemptions["]').forEach(input => {
                const name = input.getAttribute('name').replace(/\[\d+\]/, `[${index}]`);
                input.setAttribute('name', name);
            });
            
            // Add remove functionality
            const removeBtn = template.querySelector('.remove-exemption');
            removeBtn.addEventListener('click', function() {
                template.remove();
                calculateTotals();
            });
            
            // Add amount change listener
            const amountInput = template.querySelector('.amount-input');
            amountInput.addEventListener('input', calculateTotals);
            
            // Update max amount when exemption type changes
            const typeSelect = template.querySelector('.exemption-type');
            const maxAmountSpan = template.querySelector('.max-amount');
            
            typeSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const maxAmount = selectedOption.getAttribute('data-max-amount');
                maxAmountSpan.textContent = maxAmount ? '৳' + parseFloat(maxAmount).toLocaleString() : '∞';
                amountInput.setAttribute('max', maxAmount || '');
            });
            
            // Trigger change to set initial max amount
            typeSelect.dispatchEvent(new Event('change'));
            
            exemptionsContainer.appendChild(template);
            calculateTotals();
        });
        
        // Calculate totals
        function calculateTotals() {
            // Calculate total income
            let totalIncome = 0;
            document.querySelectorAll('.income-source:not(.template) .amount-input').forEach(input => {
                totalIncome += parseFloat(input.value) || 0;
            });
            
            // Calculate total exemptions
            let totalExemptions = 0;
            document.querySelectorAll('.exemption:not(.template) .amount-input').forEach(input => {
                totalExemptions += parseFloat(input.value) || 0;
            });
            
            // Calculate taxable income
            const taxableIncome = Math.max(0, totalIncome - totalExemptions);
            
            // Simple tax calculation (replace with actual tax calculation logic)
            let taxAmount = 0;
            if (taxableIncome > 350000) {
                if (taxableIncome <= 450000) {
                    taxAmount = (taxableIncome - 350000) * 0.05;
                } else if (taxableIncome <= 750000) {
                    taxAmount = 5000 + ((taxableIncome - 450000) * 0.1);
                } else if (taxableIncome <= 1150000) {
                    taxAmount = 35000 + ((taxableIncome - 750000) * 0.15);
                } else if (taxableIncome <= 1650000) {
                    taxAmount = 95000 + ((taxableIncome - 1150000) * 0.2);
                } else {
                    taxAmount = 195000 + ((taxableIncome - 1650000) * 0.25);
                }
            }
            
            // Update UI
            document.getElementById('totalIncome').textContent = '৳' + totalIncome.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('totalExemptions').textContent = '৳' + totalExemptions.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
            
            document.getElementById('previewTotalIncome').textContent = '৳' + totalIncome.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('previewTotalExemptions').textContent = '-৳' + totalExemptions.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('previewTaxableIncome').textContent = '৳' + taxableIncome.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('previewTaxAmount').textContent = '৳' + taxAmount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
        
        // Initial calculation
        calculateTotals();
        
        // Add event listeners to existing amount inputs
        document.querySelectorAll('.amount-input').forEach(input => {
            input.addEventListener('input', calculateTotals);
        });
        
        // Add event listeners to existing remove buttons
        document.querySelectorAll('.remove-income-source').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.income-source').remove();
                calculateTotals();
            });
        });
        
        document.querySelectorAll('.remove-exemption').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.exemption').remove();
                calculateTotals();
            });
        });
        
        // Handle exemption type changes for existing exemptions
        document.querySelectorAll('.exemption .exemption-type').forEach(select => {
            const maxAmountSpan = select.closest('.exemption').querySelector('.max-amount');
            const amountInput = select.closest('.exemption').querySelector('.amount-input');
            
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const maxAmount = selectedOption.getAttribute('data-max-amount');
                maxAmountSpan.textContent = maxAmount ? '৳' + parseFloat(maxAmount).toLocaleString() : '∞';
                amountInput.setAttribute('max', maxAmount || '');
                
                // If current amount exceeds new max, adjust it
                if (maxAmount && parseFloat(amountInput.value) > parseFloat(maxAmount)) {
                    amountInput.value = maxAmount;
                    calculateTotals();
                }
            });
            
            // Trigger change to set initial max amount
            select.dispatchEvent(new Event('change'));
        });
    });
</script>
@endpush
@endsection
