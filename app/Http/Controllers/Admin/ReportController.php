<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\User;
use App\Models\LoanPayment;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_loans' => Loan::count(),
            'total_disbursed' => Loan::whereIn('status', ['disbursed', 'completed'])->sum('amount'),
            'total_repaid' => LoanPayment::where('status', 'completed')->sum('amount'),
            'total_clients' => User::where('role', 'client')->count(),
            'loan_status' => Loan::selectRaw('status, COUNT(*) as count, SUM(amount) as total')
                ->groupBy('status')->get(),
            'monthly_loans' => Loan::selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(amount) as total')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')->orderBy('month')->get(),
        ];

        return view('admin.reports', compact('stats'));
    }
}
