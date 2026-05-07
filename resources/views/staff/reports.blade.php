@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Staff Reports</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-600">Total Loans</h3>
            <p class="text-3xl font-bold mt-2">{{ number_format($totalLoans) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-600">Total Savings</h3>
            <p class="text-3xl font-bold mt-2">KSh {{ number_format($totalSavings, 2) }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Loans by Status</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Status</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Count</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($data['loan_status'] as $row)
                    <tr>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($row->status == 'approved') bg-green-100 text-green-800
                                @elseif($row->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($row->status == 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($row->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $row->count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
