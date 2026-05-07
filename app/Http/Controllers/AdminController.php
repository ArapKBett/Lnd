<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Loan;
use App\Models\UserSession;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_clients' => User::where('role', 'client')->count(),
            'total_staff' => User::where('role', 'staff')->count(),
            'total_loans' => Loan::count(),
            'active_loans' => Loan::whereIn('status', ['approved', 'disbursed'])->count(),
            'pending_loans' => Loan::where('status', 'pending')->count(),
            'total_savings' => User::where('role', 'client')->sum('savings_balance'),
            'total_loan_amount' => Loan::sum('amount'),
            'total_repaid' => Loan::with('payments')->get()->sum(function($loan) {
                return $loan->payments->where('status', 'completed')->sum('amount');
            }),
        ];

        $recent_sessions = UserSession::with('user')
            ->where('is_active', true)
            ->orderBy('last_activity', 'desc')
            ->limit(10)
            ->get();

        $recent_loans = Loan::with('client')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_sessions', 'recent_loans'));
    }

    public function userManagement()
    {
        $users = User::with(['sessions' => function($query) {
            $query->where('is_active', true)->latest();
        }])->latest()->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function securityLogs()
    {
        $sessions = UserSession::with('user')
            ->orderBy('login_at', 'desc')
            ->paginate(25);

        return view('admin.security-logs', compact('sessions'));
    }

    public function deactivateUser(User $user)
    {
        $user->update(['is_active' => false]);
        
        // Logout all active sessions
        UserSession::where('user_id', $user->id)
            ->where('is_active', true)
            ->update([
                'is_active' => false,
                'logout_at' => now()
            ]);

        return back()->with('success', 'User deactivated successfully.');
    }

    public function activateUser(User $user)
    {
        $user->update(['is_active' => true]);
        return back()->with('success', 'User activated successfully.');
    }
}
