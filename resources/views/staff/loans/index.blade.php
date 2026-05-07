@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-clock text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-600">Pending Loans</h3>
                <p class="text-2xl font-bold">{{ $pendingLoans->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-600">Approved Loans</h3>
                <p class="text-2xl font-bold">{{ $approvedLoans->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-chart-line text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-600">Total Processed</h3>
                <p class="text-2xl font-bold">{{ $pendingLoans->count() + $approvedLoans->count() }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Loan Applications</h2>

    @if($pendingLoans->count() > 0)
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Pending Approval</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Loan ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Term</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applied</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pendingLoans as $loan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">#{{ $loan->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loan->client->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">KSh {{ number_format($loan->amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loan->term_months }} months</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loan->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <form action="{{ route('staff.loans.approve', $loan->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('staff.loans.reject', $loan->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if($approvedLoans->count() > 0)
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Approved Loans</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Loan ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Approved Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($approvedLoans as $loan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">#{{ $loan->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loan->client->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">KSh {{ number_format($loan->amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loan->updated_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if($pendingLoans->count() == 0 && $approvedLoans->count() == 0)
        <div class="text-center py-8">
            <i class="fas fa-file-invoice-dollar text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-600">No Loan Applications</h3>
            <p class="text-gray-500 mt-2">No loan applications to review at the moment.</p>
        </div>
    @endif
</div>
@endsection
