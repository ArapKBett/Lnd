@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Reports</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-sm font-medium text-gray-500 uppercase">Total Loans</h3>
            <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_loans']) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-sm font-medium text-gray-500 uppercase">Total Disbursed</h3>
            <p class="text-3xl font-bold mt-2">KSh {{ number_format($stats['total_disbursed'], 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-sm font-medium text-gray-500 uppercase">Total Repaid</h3>
            <p class="text-3xl font-bold mt-2">KSh {{ number_format($stats['total_repaid'], 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-sm font-medium text-gray-500 uppercase">Total Clients</h3>
            <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_clients']) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Loans by Status</h2>
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Status</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Count</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Total Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($stats['loan_status'] as $row)
                    <tr>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($row->status == 'approved') bg-green-100 text-green-800
                                @elseif($row->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($row->status == 'rejected') bg-red-100 text-red-800
                                @elseif($row->status == 'disbursed') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($row->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $row->count }}</td>
                        <td class="px-4 py-2">KSh {{ number_format($row->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Monthly Loan Applications ({{ date('Y') }})</h2>
            @if($stats['monthly_loans']->count() > 0)
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Month</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Applications</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($stats['monthly_loans'] as $row)
                        <tr>
                            <td class="px-4 py-2">{{ date('F', mktime(0, 0, 0, $row->month, 1)) }}</td>
                            <td class="px-4 py-2">{{ $row->count }}</td>
                            <td class="px-4 py-2">KSh {{ number_format($row->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 text-center py-8">No loan data for this year.</p>
            @endif
        </div>
    </div>
</div>
@endsection
