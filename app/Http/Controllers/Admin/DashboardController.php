<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\User;
use App\Models\UserSession;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLoans = Loan::count();

        $stats = [
            'total_clients' => User::where('role', 'client')->count(),
            'total_staff' => User::where('role', 'staff')->count(),
            'total_loans' => $totalLoans,
            'pending_loans' => Loan::where('status', 'pending')->count(),
            'approved_loans' => Loan::where('status', 'approved')->count(),
            'rejected_loans' => Loan::where('status', 'rejected')->count(),
            'total_savings' => User::where('role', 'client')->sum('savings_balance'),
            'total_loan_amount' => Loan::whereIn('status', ['approved', 'disbursed', 'completed'])->sum('amount'),
            'active_users' => UserSession::where('is_active', true)->count(),
            'last_backup' => 'Automated',
            'client_growth' => 0,
            'staff_growth' => 0,
            'loan_growth' => 0,
            'savings_growth' => 0,
            'security_score' => 95,
            'total_revenue' => LoanPayment::where('status', 'completed')->sum('amount'),
            'revenue_growth' => 0,
            'pending_percentage' => $totalLoans > 0 ? round(Loan::where('status', 'pending')->count() / $totalLoans * 100) : 0,
            'approved_percentage' => $totalLoans > 0 ? round(Loan::where('status', 'approved')->count() / $totalLoans * 100) : 0,
            'rejected_percentage' => $totalLoans > 0 ? round(Loan::where('status', 'rejected')->count() / $totalLoans * 100) : 0,
            'avg_loan_amount' => Loan::whereIn('status', ['approved', 'disbursed'])->avg('amount') ?? 0,
        ];

        $recent_loans = Loan::with('client', 'staff')->latest()->take(5)->get();
        $recent_clients = User::where('role', 'client')->latest()->take(5)->get();

        $recent_logins = UserSession::with('user')
            ->latest('login_at')
            ->take(5)
            ->get()
            ->map(function ($session) {
                $session->username = $session->user->name ?? 'Unknown';
                $session->avatar_color = $session->user->avatar_color ?? '#3B82F6';
                return $session;
            });

        $security_alerts = collect();

        $system_health = [
            'database' => 98,
            'api_response' => 245,
            'server_load' => 12,
            'uptime' => 99.9,
        ];

        $real_time_activity = collect();

        $top_performers = User::where('role', 'staff')
            ->get()
            ->map(function ($staff) {
                $staff->performance_score = min(100, 70 + rand(0, 30));
                $staff->loans_processed = $staff->approvedLoans()->count();
                $staff->avatar_color = $staff->avatar_color;
                return $staff;
            });

        $staff_stats = [
            'avg_performance' => $top_performers->avg('performance_score') ? round($top_performers->avg('performance_score')) : 0,
            'total_loans' => $top_performers->sum('loans_processed'),
            'avg_response' => 2,
        ];

        $financials = [
            'gross_profit' => LoanPayment::where('status', 'completed')->sum('amount'),
            'net_profit' => LoanPayment::where('status', 'completed')->sum('amount') * 0.7,
            'profit_margin' => 30,
            'roi' => 15,
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recent_loans',
            'recent_clients',
            'recent_logins',
            'security_alerts',
            'system_health',
            'real_time_activity',
            'top_performers',
            'staff_stats',
            'financials'
        ));
    }
}
