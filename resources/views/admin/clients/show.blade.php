@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Client Details</h1>
        <a href="{{ route('admin.clients.index') }}" class="text-blue-600 hover:underline">Back to Clients</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="grid grid-cols-2 gap-4">
            <div><span class="text-gray-500">Name:</span> <span class="font-semibold">{{ $client->name }}</span></div>
            <div><span class="text-gray-500">Email:</span> <span class="font-semibold">{{ $client->email }}</span></div>
            <div><span class="text-gray-500">Phone:</span> <span class="font-semibold">{{ $client->phone ?? 'N/A' }}</span></div>
            <div><span class="text-gray-500">ID Number:</span> <span class="font-semibold">{{ $client->id_number ?? 'N/A' }}</span></div>
            <div><span class="text-gray-500">Savings Balance:</span> <span class="font-semibold">KSh {{ number_format($client->savings_balance, 2) }}</span></div>
            <div><span class="text-gray-500">Loan Limit:</span> <span class="font-semibold">KSh {{ number_format($client->loan_limit, 2) }}</span></div>
            <div><span class="text-gray-500">Credit Score:</span> <span class="font-semibold">{{ $client->credit_score }}</span></div>
            <div><span class="text-gray-500">Member Since:</span> <span class="font-semibold">{{ $client->created_at->format('M d, Y') }}</span></div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Loan History</h2>
        @if($client->loans->count() > 0)
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">ID</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Amount</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Term</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Status</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($client->loans as $loan)
                <tr>
                    <td class="px-4 py-2">#{{ $loan->id }}</td>
                    <td class="px-4 py-2">KSh {{ number_format($loan->amount, 2) }}</td>
                    <td class="px-4 py-2">{{ $loan->term_months }} months</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs rounded-full {{ $loan->status_badge }}">{{ ucfirst($loan->status) }}</span>
                    </td>
                    <td class="px-4 py-2">{{ $loan->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p class="text-gray-500 text-center py-4">No loans found.</p>
        @endif
    </div>
</div>
@endsection
