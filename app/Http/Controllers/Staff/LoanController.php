<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $pendingLoans = Loan::with('client')->where('status', 'pending')->get();
        $approvedLoans = Loan::with('client')->where('status', 'approved')->get();

        return view('staff.loans.index', compact('pendingLoans', 'approvedLoans'));
    }

    public function approve($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->status = 'approved';
        $loan->staff_id = auth()->id();
        $loan->save();

        return redirect()->route('staff.loans.index')->with('success', 'Loan approved successfully!');
    }

    public function reject($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->status = 'rejected';
        $loan->staff_id = auth()->id();
        $loan->save();

        return redirect()->route('staff.loans.index')->with('success', 'Loan rejected successfully!');
    }
}
