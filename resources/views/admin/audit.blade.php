@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Audit Log</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Recent Login History</h2>

        @if($recent_logins->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP Address</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platform</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Browser</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Login Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($recent_logins as $login)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $login->user->name ?? 'Unknown' }}</td>
                        <td class="px-4 py-3">{{ ucfirst($login->user->role ?? 'N/A') }}</td>
                        <td class="px-4 py-3">{{ $login->ip_address }}</td>
                        <td class="px-4 py-3">{{ $login->platform ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $login->browser ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $login->login_at ? $login->login_at->format('M d, Y H:i') : 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <p class="text-gray-500 text-center py-8">No login records found.</p>
        @endif
    </div>
</div>
@endsection
