@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Loan #{{ $loan->id }}</h1>
        <a href="{{ route('admin.loans.index') }}" class="text-blue-600 hover:underline">Back to Loans</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="grid grid-cols-2 gap-4">
            <div><span class="text-gray-500">Client:</span> <span class="font-semibold">{{ $loan->client->name }}</span></div>
            <div><span class="text-gray-500">Amount:</span> <span class="font-semibold">KSh {{ number_format($loan->amount, 2) }}</span></div>
            <div><span class="text-gray-500">Term:</span> <span class="font-semibold">{{ $loan->term_months }} months</span></div>
            <div><span class="text-gray-500">Interest Rate:</span> <span class="font-semibold">{{ $loan->interest_rate }}%</span></div>
            <div><span class="text-gray-500">Status:</span>
                <span class="px-2 py-1 text-xs rounded-full {{ $loan->status_badge }}">{{ ucfirst($loan->status) }}</span>
            </div>
            <div><span class="text-gray-500">Monthly Payment:</span> <span class="font-semibold">KSh {{ number_format($loan->monthly_payment ?? 0, 2) }}</span></div>
            <div><span class="text-gray-500">Remaining Balance:</span> <span class="font-semibold">KSh {{ number_format($loan->remaining_balance ?? 0, 2) }}</span></div>
            <div><span class="text-gray-500">Applied:</span> <span class="font-semibold">{{ $loan->created_at->format('M d, Y') }}</span></div>
        </div>
    </div>

    @if($loan->status === 'approved')
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold mb-4">Disburse Loan</h2>
        <form action="{{ route('admin.loans.disburse', $loan) }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Disbursement Method</label>
                    <select name="disbursement_method" class="w-full p-2 border rounded" required>
                        <option value="mpesa">M-Pesa</option>
                        <option value="crypto">Cryptocurrency</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">M-Pesa Number</label>
                    <input type="text" name="mpesa_number" value="{{ $loan->client->mpesa_number }}" class="w-full p-2 border rounded">
                </div>
            </div>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Disburse KSh {{ number_format($loan->amount, 2) }}
            </button>
        </form>
    </div>
    @endif

    @if($loan->payments->count() > 0)
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Payment Schedule</h2>
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">#</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Due Date</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Amount</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Status</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Paid On</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($loan->payments as $index => $payment)
                <tr>
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $payment->due_date->format('M d, Y') }}</td>
                    <td class="px-4 py-2">KSh {{ number_format($payment->amount, 2) }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($payment->status == 'completed') bg-green-100 text-green-800
                            @elseif($payment->status == 'overdue') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
