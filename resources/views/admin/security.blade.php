@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Security Dashboard</h1>

    <!-- Overview Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-8">
        <div class="bg-white p-4 rounded-lg shadow-md text-center">
            <div class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] }}</div>
            <div class="text-xs text-gray-500 uppercase mt-1">Total Users</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md text-center border-l-4 border-purple-500">
            <div class="text-2xl font-bold text-purple-700">{{ $stats['total_admins'] }}</div>
            <div class="text-xs text-gray-500 uppercase mt-1">Admins</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md text-center border-l-4 border-green-500">
            <div class="text-2xl font-bold text-green-700">{{ $stats['total_staff'] }}</div>
            <div class="text-xs text-gray-500 uppercase mt-1">Staff</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md text-center border-l-4 border-blue-500">
            <div class="text-2xl font-bold text-blue-700">{{ $stats['total_clients'] }}</div>
            <div class="text-xs text-gray-500 uppercase mt-1">Clients</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md text-center border-l-4 border-yellow-500">
            <div class="text-2xl font-bold text-yellow-700">{{ $stats['active_sessions'] }}</div>
            <div class="text-xs text-gray-500 uppercase mt-1">Active Now</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md text-center border-l-4 border-indigo-500">
            <div class="text-2xl font-bold text-indigo-700">{{ $stats['today_logins'] }}</div>
            <div class="text-xs text-gray-500 uppercase mt-1">Logins Today</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md text-center border-l-4 border-red-500">
            <div class="text-2xl font-bold text-red-700">{{ $stats['never_logged_in'] }}</div>
            <div class="text-xs text-gray-500 uppercase mt-1">Never Logged In</div>
        </div>
    </div>

    <!-- Active Sessions -->
    <div class="bg-white rounded-lg shadow-md mb-8">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">
                    <i class="fas fa-circle text-green-500 text-xs mr-2"></i>Active Sessions ({{ $active_sessions->count() }})
                </h2>
                <span class="text-sm text-gray-500">Users currently online</span>
            </div>
        </div>
        <div class="p-6">
            @if($active_sessions->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <th class="pb-3">User</th>
                            <th class="pb-3">Role</th>
                            <th class="pb-3">IP Address</th>
                            <th class="pb-3">Device</th>
                            <th class="pb-3">Browser</th>
                            <th class="pb-3">Platform</th>
                            <th class="pb-3">Last Activity</th>
                            <th class="pb-3">Session Started</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($active_sessions as $session)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3" style="background-color: {{ $session->user->avatar_color ?? '#6B7280' }}">
                                        {{ strtoupper(substr($session->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-sm">{{ $session->user->name ?? 'Unknown' }}</div>
                                        <div class="text-xs text-gray-400">{{ $session->user->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs rounded-full font-medium
                                    @if($session->user->role == 'admin') bg-purple-100 text-purple-800
                                    @elseif($session->user->role == 'staff') bg-green-100 text-green-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ ucfirst($session->user->role ?? 'N/A') }}
                                </span>
                            </td>
                            <td class="py-3 text-sm font-mono">{{ $session->ip_address }}</td>
                            <td class="py-3 text-sm">{{ $session->device_type ?? 'N/A' }}</td>
                            <td class="py-3 text-sm">{{ $session->browser ?? 'N/A' }}</td>
                            <td class="py-3 text-sm">{{ $session->platform ?? 'N/A' }}</td>
                            <td class="py-3 text-sm">
                                @if($session->last_activity)
                                    <span class="text-green-600">{{ $session->last_activity->diffForHumans() }}</span>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="py-3 text-sm text-gray-500">
                                {{ $session->login_at ? $session->login_at->format('M d, H:i') : 'N/A' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="text-center py-6 text-gray-400">
                    <i class="fas fa-user-slash text-3xl mb-2"></i>
                    <p>No active sessions at the moment.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- All Users by Role -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Admins -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-4 border-b bg-purple-50">
                <h3 class="font-semibold text-purple-800">
                    <i class="fas fa-user-shield mr-2"></i>Administrators ({{ $admins->count() }})
                </h3>
            </div>
            <div class="divide-y">
                @foreach($admins as $user)
                <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold mr-3" style="background-color: {{ $user->avatar_color }}">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-medium text-sm">{{ $user->name }}</div>
                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        @if($user->last_login_at)
                            <div class="text-xs text-gray-500">Last login</div>
                            <div class="text-xs text-gray-700">{{ $user->last_login_at->diffForHumans() }}</div>
                        @else
                            <span class="text-xs text-red-400">Never logged in</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Staff -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-4 border-b bg-green-50">
                <h3 class="font-semibold text-green-800">
                    <i class="fas fa-user-tie mr-2"></i>Staff Members ({{ $staff->count() }})
                </h3>
            </div>
            <div class="divide-y">
                @foreach($staff as $user)
                <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold mr-3" style="background-color: {{ $user->avatar_color }}">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-medium text-sm">{{ $user->name }}</div>
                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        @if($user->last_login_at)
                            <div class="text-xs text-gray-500">Last login</div>
                            <div class="text-xs text-gray-700">{{ $user->last_login_at->diffForHumans() }}</div>
                        @else
                            <span class="text-xs text-red-400">Never logged in</span>
                        @endif
                    </div>
                </div>
                @endforeach
                @if($staff->count() == 0)
                <div class="p-6 text-center text-gray-400 text-sm">No staff members.</div>
                @endif
            </div>
        </div>

        <!-- Clients -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-4 border-b bg-blue-50">
                <h3 class="font-semibold text-blue-800">
                    <i class="fas fa-users mr-2"></i>Clients ({{ $clients->count() }})
                </h3>
            </div>
            <div class="divide-y max-h-96 overflow-y-auto">
                @foreach($clients as $user)
                <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold mr-3" style="background-color: {{ $user->avatar_color }}">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-medium text-sm">{{ $user->name }}</div>
                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs">
                            @if($user->is_active)
                                <span class="text-green-600"><i class="fas fa-circle text-xs"></i> Active</span>
                            @else
                                <span class="text-red-500"><i class="fas fa-circle text-xs"></i> Inactive</span>
                            @endif
                        </div>
                        @if($user->last_login_at)
                            <div class="text-xs text-gray-500">{{ $user->last_login_at->diffForHumans() }}</div>
                        @else
                            <span class="text-xs text-red-400">Never</span>
                        @endif
                    </div>
                </div>
                @endforeach
                @if($clients->count() == 0)
                <div class="p-6 text-center text-gray-400 text-sm">No clients registered.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Login History -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">
                <i class="fas fa-history mr-2 text-gray-400"></i>Recent Login History
            </h2>
        </div>
        <div class="p-6">
            @if($recent_logins->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <th class="pb-3">User</th>
                            <th class="pb-3">Role</th>
                            <th class="pb-3">IP Address</th>
                            <th class="pb-3">Device</th>
                            <th class="pb-3">Browser / Platform</th>
                            <th class="pb-3">Login Time</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recent_logins as $login)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3" style="background-color: {{ $login->user->avatar_color ?? '#6B7280' }}">
                                        {{ strtoupper(substr($login->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-sm">{{ $login->user->name ?? 'Unknown' }}</div>
                                        <div class="text-xs text-gray-400">{{ $login->user->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs rounded-full font-medium
                                    @if(($login->user->role ?? '') == 'admin') bg-purple-100 text-purple-800
                                    @elseif(($login->user->role ?? '') == 'staff') bg-green-100 text-green-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ ucfirst($login->user->role ?? 'N/A') }}
                                </span>
                            </td>
                            <td class="py-3 text-sm font-mono">{{ $login->ip_address }}</td>
                            <td class="py-3 text-sm">{{ $login->device_type ?? 'N/A' }}</td>
                            <td class="py-3 text-sm">{{ $login->browser ?? '' }} / {{ $login->platform ?? '' }}</td>
                            <td class="py-3 text-sm">
                                @if($login->login_at)
                                    <div>{{ $login->login_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $login->login_at->format('H:i:s') }}</div>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="py-3">
                                @if($login->is_active)
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Online</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">Offline</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-clipboard-list text-3xl mb-2"></i>
                    <p>No login records found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
