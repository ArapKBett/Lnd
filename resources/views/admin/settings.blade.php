@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">System Settings</h1>

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold mb-4">General Settings</h2>
        <div class="space-y-4">
            <div class="flex justify-between items-center py-3 border-b">
                <div>
                    <h3 class="font-medium">Application Name</h3>
                    <p class="text-sm text-gray-500">WealthBuild Loans</p>
                </div>
            </div>
            <div class="flex justify-between items-center py-3 border-b">
                <div>
                    <h3 class="font-medium">Default Interest Rate</h3>
                    <p class="text-sm text-gray-500">12% per annum</p>
                </div>
            </div>
            <div class="flex justify-between items-center py-3 border-b">
                <div>
                    <h3 class="font-medium">CreditBoost Multiplier</h3>
                    <p class="text-sm text-gray-500">5x savings balance</p>
                </div>
            </div>
            <div class="flex justify-between items-center py-3">
                <div>
                    <h3 class="font-medium">Base Loan Limit</h3>
                    <p class="text-sm text-gray-500">KSh 50,000</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Payment Gateways</h2>
        <div class="space-y-4">
            <div class="flex justify-between items-center py-3 border-b">
                <div>
                    <h3 class="font-medium">M-Pesa Integration</h3>
                    <p class="text-sm text-gray-500">{{ config('mpesa.environment', 'sandbox') }} mode</p>
                </div>
                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Sandbox</span>
            </div>
            <div class="flex justify-between items-center py-3">
                <div>
                    <h3 class="font-medium">CoinRemitter (Crypto)</h3>
                    <p class="text-sm text-gray-500">BTC, USDT supported</p>
                </div>
                <span class="px-2 py-1 text-xs rounded-full {{ config('crypto.api_key') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ config('crypto.api_key') ? 'Configured' : 'Not Configured' }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
