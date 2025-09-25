@extends('layouts.admin')
@section('content')
<div class="p-6">
    <h1 class="text-3xl mb-4">Clients</h1>
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Name</th>
                <th class="p-2">Email</th>
                <th class="p-2">Savings</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr>
                <td class="p-2">{{ $client->name }}</td>
                <td class="p-2">{{ $client->email }}</td>
                <td class="p-2">{{ $client->savings ? number_format($client->savings->balance, 2) : '0.00' }}</td>
                <td class="p-2">
                    <a href="{{ route('admin.clients.show', $client->id) }}" class="text-blue-500">View</a>
                    <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $clients->links() }}
</div>
@endsection
