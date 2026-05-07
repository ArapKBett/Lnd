@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Security Monitoring</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Active Sessions</h2>

        @if($sessions->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP Address</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Device</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Browser</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Last Activity</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($sessions as $session)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $session->user->name ?? 'Unknown' }}</td>
                        <td class="px-4 py-3">{{ $session->ip_address }}</td>
                        <td class="px-4 py-3">{{ $session->device_type ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $session->browser ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $session->last_activity ? $session->last_activity->diffForHumans() : 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <p class="text-gray-500 text-center py-8">No active sessions found.</p>
        @endif
    </div>
</div>
@endsection
