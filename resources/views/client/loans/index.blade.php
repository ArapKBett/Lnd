@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-hand-holding-usd text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-600">My Loans</h3>
                <p class="text-2xl font-bold">{{ $loans->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-piggy-bank text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-600">Savings Balance</h3>
                <p class="text-2xl font-bold">KSh {{ auth()->user()->savings_balance }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-chart-line text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-600">Loan Limit</h3>
                <p class="text-2xl font-bold">KSh {{ auth()->user()->loan_limit }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">My Loan Applications</h2>
        <a href="{{ route('client.loans.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
            Apply for Loan
        </a>
    </div>

    @if($loans->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Loan ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applied Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($loans as $loan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">#{{ $loan->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">KSh {{ number_format($loan->amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($loan->status == 'approved') bg-green-100 text-green-800
                                @elseif($loan->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($loan->status == 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loan->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8">
            <i class="fas fa-file-invoice-dollar text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-600">No Loan Applications</h3>
            <p class="text-gray-500 mt-2">You haven't applied for any loans yet.</p>
            <a href="{{ route('client.loans.create') }}" class="inline-block mt-4 bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
                Apply for Your First Loan
            </a>
        </div>
    @endif
</div>

<div class="bg-white p-6 rounded-lg shadow-md mt-6">
    <h2 class="text-xl font-semibold mb-4">CreditBoost Feature</h2>
    <p class="text-gray-600 mb-4">Increase your loan limit by saving with us! For every KSh 1 you save, you get KSh 5 in additional borrowing power.</p>
    
    <div class="bg-purple-50 border-l-4 border-purple-500 p-4">
        <div class="flex items-center">
            <i class="fas fa-rocket text-purple-600 text-xl mr-3"></i>
            <div>
                <h4 class="font-semibold text-purple-800">Current Boost Calculation</h4>
                <p class="text-purple-600">Savings: KSh {{ auth()->user()->savings_balance }} × 5 = KSh {{ auth()->user()->savings_balance * 5 }} additional loan limit</p>
            </div>
        </div>
    </div>
</div>
@endsection
