<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $sessions = UserSession::with('user')
            ->where('is_active', true)
            ->latest('last_activity')
            ->take(20)
            ->get();

        return view('admin.security', compact('sessions'));
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
