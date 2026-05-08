<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSession;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings');
    }

    public function update(Request $request)
    {
        return redirect()->route('admin.settings')->with('success', 'Settings updated.');
    }

    public function security()
    {
        // All users in the system grouped by role
        $users = User::orderBy('role')->orderBy('name')->get();
        $admins = $users->where('role', 'admin');
        $staff = $users->where('role', 'staff');
        $clients = $users->where('role', 'client');

        // Active sessions
        $active_sessions = UserSession::with('user')
            ->where('is_active', true)
            ->latest('last_activity')
            ->get();

        // Recent logins (last 50)
        $recent_logins = UserSession::with('user')
            ->latest('login_at')
            ->take(50)
            ->get();

        // Users who logged in today
        $today_logins = UserSession::with('user')
            ->whereDate('login_at', today())
            ->distinct('user_id')
            ->count('user_id');

        // Users who never logged in
        $never_logged_in = User::whereNull('last_login_at')->count();

        // Stats
        $stats = [
            'total_users' => $users->count(),
            'total_admins' => $admins->count(),
            'total_staff' => $staff->count(),
            'total_clients' => $clients->count(),
            'active_sessions' => $active_sessions->count(),
            'today_logins' => $today_logins,
            'never_logged_in' => $never_logged_in,
        ];

        return view('admin.security', compact(
            'admins', 'staff', 'clients',
            'active_sessions', 'recent_logins', 'stats'
        ));
    }

    public function audit()
    {
        $recent_logins = UserSession::with('user')
            ->latest('login_at')
            ->take(50)
            ->get();

        return view('admin.audit', compact('recent_logins'));
    }
}
