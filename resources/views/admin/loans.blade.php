@extends('layouts.admin')
@section('content')
<div class="p-6">
    <h1 class="text-3xl mb-4">Loans</h1>
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Client</th>
                <th class="p-2">Amount</th>
                <th class="p-2">Status</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
            <tr>
                <td class="p-2">{{ $loan->client->name }}</td>
                <td class="p-2">{{ number_format($loan->amount, 2) }}</td>
                <td class="p-2">{{ ucfirst($loan->status) }}</td>
                <td class="p-2">
                    <a href="{{ route('admin.loans.show', $loan->id) }}" class="text-blue-500">View</a>
                    <form action="{{ route('admin.loans.update', $loan->id) }}" method="POST" class="inline">
                        @csrf @method('PATCH')
                        <select name="status" onchange="this.form.submit()">
                            <option value="pending" {{ $loan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $loan->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $loan->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $loans->links() }}
</div>
@endsection
