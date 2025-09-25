<?php
namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;
use App\Models\Loan;

class DashboardController extends Controller {
    public function index() {
        $pendingLoans = Loan::where('status', 'pending')->count();
        $approvedLoans = Loan::where('status', 'approved')->count();
        return view('staff.dashboard', compact('pendingLoans', 'approvedLoans'));
    }
}
