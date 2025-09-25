<?php
namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Savings;

class ReportController extends Controller {
    public function index() {
        $totalLoans = Loan::count();
        $totalSavings = Savings::sum('balance');
        $data = [
            'loan_status' => Loan::selectRaw('status, COUNT(*) as count')->groupBy('status')->get(),
            'savings_trend' => Savings::selectRaw('DATE(created_at) as date, SUM(balance) as total')->groupBy('date')->get(),
        ];
        return view('staff.reports', compact('totalLoans', 'totalSavings', 'data'));
    }
}
