document.addEventListener('DOMContentLoaded', function() {
    // Get form elements
    const incomeInput = document.getElementById('annual-income');
    const filingStatusSelect = document.getElementById('filing-status');
    const taxYearSelect = document.getElementById('tax-year');
    
    // Get result elements
    const taxableIncomeSpan = document.getElementById('taxable-income');
    const taxRateSpan = document.getElementById('tax-rate');
    const estimatedTaxSpan = document.getElementById('estimated-tax');
    const estimatedRefundSpan = document.getElementById('estimated-refund');
    
    // Debounce function to limit API calls
    let debounceTimer;
    function debounce(callback, delay) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(callback, delay);
    }
    
    // Function to handle input changes
    function handleInputChange() {
        const income = parseFloat(incomeInput.value) || 0;
        if (income > 0) {
            calculateTax();
        } else {
            // Reset the display if income is 0 or empty
            resetCalculator();
        }
    }
    
    // Reset calculator display
    function resetCalculator() {
        taxableIncomeSpan.textContent = '৳0';
        taxRateSpan.textContent = '0%';
        estimatedTaxSpan.textContent = '৳0';
        estimatedRefundSpan.textContent = '৳0';
        
        const bracketsContainer = document.getElementById('tax-brackets-container');
        if (bracketsContainer) {
            bracketsContainer.innerHTML = '';
        }
    }
    
    // Add event listeners for real-time calculation
    if (incomeInput && filingStatusSelect && taxYearSelect) {
        // Calculate on income input with debounce
        incomeInput.addEventListener('input', function() {
            debounce(handleInputChange, 500);
        });
        
        // Calculate immediately when dropdowns change
        filingStatusSelect.addEventListener('change', handleInputChange);
        taxYearSelect.addEventListener('change', handleInputChange);
        
        // Initial calculation if there's a value in the input
        if (incomeInput.value) {
            handleInputChange();
        }
    }
    
    function calculateTax() {
        const income = parseFloat(incomeInput.value) || 0;
        if (income <= 0) return;
        
        const filingStatus = filingStatusSelect.value;
        const taxYear = taxYearSelect.value;
        
        // Show loading state on the tax amount
        const previousTax = estimatedTaxSpan.textContent;
        estimatedTaxSpan.textContent = 'Calculating...';
        
        // Call the API to calculate tax
        fetch('/api/tax/calculate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                income: income,
                filing_type: mapFilingStatusToType(filingStatus),
                year: taxYear
            })
        })
        .then(handleResponse)
        .then(data => {
            if (data.success) {
                updateTaxResults(data);
            } else {
                throw new Error(data.message || 'Failed to calculate tax');
            }
        })
        .catch(error => {
            console.error('Error calculating tax:', error);
            estimatedTaxSpan.textContent = previousTax; // Revert to previous value on error
        });
    }
    
    function handleResponse(response) {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    }
    
    function updateTaxResults(data) {
        // Update the UI with the calculated values
        taxableIncomeSpan.textContent = formatCurrency(data.taxable_income || 0);
        taxRateSpan.textContent = `${(data.effective_tax_rate || 0).toFixed(2)}%`;
        estimatedTaxSpan.textContent = formatCurrency(data.tax_amount || 0);
        
        // For demo purposes, assuming no payments made yet
        estimatedRefundSpan.textContent = '৳0';
        
        // Show tax brackets if available
        if (data.tax_brackets && data.tax_brackets.length > 0) {
            updateTaxBrackets(data.tax_brackets);
        }
    }
    
    function mapFilingStatusToType(filingStatus) {
        // Map the UI filing status to the backend's expected values
        const statusMap = {
            'Single': 'individual',
            'Married Filing Jointly': 'business',
            'Married Filing Separately': 'freelancer',
            'Head of Household': 'individual'
        };
        return statusMap[filingStatus] || 'individual';
    }
    
    function formatCurrency(amount) {
        return new Intl.NumberFormat('en-BD', {
            style: 'currency',
            currency: 'BDT',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(amount).replace('BDT', '৳');
    }
    
    function updateTaxBrackets(brackets) {
        const bracketsContainer = document.getElementById('tax-brackets-container');
        if (!bracketsContainer) return;
        
        let html = '<div class="mt-8">';
        html += '<h4 class="text-lg font-medium mb-4">Tax Brackets</h4>';
        html += '<div class="space-y-2">';
        
        brackets.forEach(bracket => {
            const min = bracket.min_income ? formatCurrency(bracket.min_income) : '0';
            const max = bracket.max_income ? formatCurrency(bracket.max_income) : 'and above';
            const range = bracket.max_income ? `${min} - ${max}` : `Above ${min}`;
            
            html += `
                <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                    <div>
                        <span class="text-gray-700">${range}</span>
                        <span class="text-sm text-gray-500 block">${bracket.rate}% rate</span>
                    </div>
                    <span class="font-medium">${formatCurrency(bracket.tax || 0)}</span>
                </div>
            `;
        });
        
        html += '</div></div>';
        bracketsContainer.innerHTML = html;
    }
});
