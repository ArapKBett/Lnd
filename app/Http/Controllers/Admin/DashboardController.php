<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\User;

class DashboardController extends Controller {
    public function index() {
        $totalLoans = Loan::count();
        $pendingLoans = Loan::where('status', 'pending')->count();
        $totalClients = User::where('role', 'client')->count();
        $totalSavings = \App\Models\Savings::sum('balance');
        return view('admin.dashboard', compact('totalLoans', 'pendingLoans', 'totalClients', 'totalSavings'));
    }
}
