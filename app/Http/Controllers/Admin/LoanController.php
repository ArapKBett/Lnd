<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller {
    public function index() {
        $loans = Loan::with('client')->paginate(10);
        return view('admin.loans', compact('loans'));
    }

    public function show($id) {
        $loan = Loan::with('client', 'payments')->findOrFail($id);
        return view('admin.loans.show', compact('loan'));
    }

    public function update(Request $request, $id) {
        $loan = Loan::findOrFail($id);
        $request->validate(['status' => 'in:pending,approved,rejected,repaid']);
        $loan->update(['status' => $request->status]);
        return redirect()->route('admin.loans.index')->with('success', 'Loan status updated.');
    }
}
