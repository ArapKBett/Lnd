@extends('layouts.client')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Apply for Loan</h2>

        <!-- CreditBoost Information -->
        <div class="bg-purple-50 border-l-4 border-purple-500 p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-rocket text-purple-600 text-xl mr-3"></i>
                <div>
                    <h4 class="font-semibold text-purple-800">CreditBoost Active!</h4>
                    <p class="text-purple-600">Your savings balance: KSh {{ number_format(auth()->user()->savings_balance, 2) }}</p>
                    <p class="text-purple-600">Additional borrowing power: KSh {{ number_format(auth()->user()->savings_balance * 5, 2) }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('client.loans.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Loan Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Loan Amount (KSh)</label>
                    <input type="number" 
                           id="amount" 
                           name="amount" 
                           min="1000" 
                           max="{{ auth()->user()->loan_limit }}"
                           required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                           placeholder="Enter loan amount">
                    <p class="text-xs text-gray-500 mt-1">Maximum: KSh {{ number_format(auth()->user()->loan_limit, 2) }}</p>
                </div>

                <!-- Loan Term -->
                <div>
                    <label for="term_months" class="block text-sm font-medium text-gray-700 mb-2">Loan Term (Months)</label>
                    <select id="term_months" 
                            name="term_months" 
                            required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Select term</option>
                        <option value="3">3 Months</option>
                        <option value="6">6 Months</option>
                        <option value="12">12 Months</option>
                        <option value="24">24 Months</option>
                    </select>
                </div>

                <!-- Interest Rate (Read-only) -->
                <div>
                    <label for="interest_rate" class="block text-sm font-medium text-gray-700 mb-2">Interest Rate (%)</label>
                    <input type="number" 
                           id="interest_rate" 
                           name="interest_rate" 
                           value="12" 
                           readonly 
                           class="w-full px-3 py-2 border border-gray-300 bg-gray-100 rounded-md">
                    <p class="text-xs text-gray-500 mt-1">Standard rate</p>
                </div>

                <!-- Loan Purpose -->
                <div>
                    <label for="purpose" class="block text-sm font-medium text-gray-700 mb-2">Loan Purpose</label>
                    <select id="purpose" 
                            name="purpose" 
                            required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Select purpose</option>
                        <option value="Business">Business Expansion</option>
                        <option value="Education">Education</option>
                        <option value="Emergency">Emergency</option>
                        <option value="Home">Home Improvement</option>
                        <option value="Medical">Medical</option>
                        <option value="Personal">Personal Use</option>
                        <option value="Vehicle">Vehicle Purchase</option>
                    </select>
                </div>
            </div>

            <!-- Savings Boost Option -->
            <div class="mt-6">
                <div class="flex items-center mb-4">
                    <input type="checkbox" 
                           id="savings_boost" 
                           name="savings_boost" 
                           value="{{ auth()->user()->savings_balance * 5 }}"
                           class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                    <label for="savings_boost" class="ml-2 block text-sm text-gray-900">
                        Apply CreditBoost (Add KSh {{ number_format(auth()->user()->savings_balance * 5, 2) }} to loan amount)
                    </label>
                </div>
                <p class="text-sm text-gray-600">By checking this, you'll use your savings to increase your loan limit</p>
            </div>

            <!-- Loan Summary -->
            <div class="mt-8 bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold text-gray-800 mb-3">Loan Summary</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>Principal Amount:</span>
                        <span id="principal-amount">KSh 0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>CreditBoost:</span>
                        <span id="boost-amount">KSh 0.00</span>
                    </div>
                    <div class="flex justify-between font-semibold">
                        <span>Total Amount:</span>
                        <span id="total-amount">KSh 0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Monthly Payment:</span>
                        <span id="monthly-payment">KSh 0.00</span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" 
                        class="w-full bg-purple-600 text-white py-3 px-4 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 font-semibold">
                    Apply for Loan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    const termSelect = document.getElementById('term_months');
    const boostCheckbox = document.getElementById('savings_boost');
    
    const principalAmount = document.getElementById('principal-amount');
    const boostAmount = document.getElementById('boost-amount');
    const totalAmount = document.getElementById('total-amount');
    const monthlyPayment = document.getElementById('monthly-payment');
    
    function calculateLoan() {
        const principal = parseFloat(amountInput.value) || 0;
        const boost = boostCheckbox.checked ? parseFloat(boostCheckbox.value) : 0;
        const term = parseInt(termSelect.value) || 12;
        const interestRate = 12; // 12% annual
        
        const total = principal + boost;
        const monthlyRate = interestRate / 100 / 12;
        const payment = total * monthlyRate * Math.pow(1 + monthlyRate, term) / (Math.pow(1 + monthlyRate, term) - 1);
        
        principalAmount.textContent = 'KSh ' + principal.toLocaleString('en-KE', {minimumFractionDigits: 2});
        boostAmount.textContent = 'KSh ' + boost.toLocaleString('en-KE', {minimumFractionDigits: 2});
        totalAmount.textContent = 'KSh ' + total.toLocaleString('en-KE', {minimumFractionDigits: 2});
        monthlyPayment.textContent = 'KSh ' + (isNaN(payment) ? '0.00' : payment.toFixed(2));
    }
    
    amountInput.addEventListener('input', calculateLoan);
    termSelect.addEventListener('change', calculateLoan);
    boostCheckbox.addEventListener('change', calculateLoan);
    
    // Initial calculation
    calculateLoan();
});
</script>
@endsection
