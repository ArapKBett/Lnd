<?php
namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class ApprovalController extends Controller {
    public function index() {
        $loans = Loan::where('status', 'pending')->with('client')->paginate(10);
        return view('staff.approvals', compact('loans'));
    }

    public function update(Request $request, $id) {
        $loan = Loan::findOrFail($id);
        $request->validate(['status' => 'in:approved,rejected']);
        $loan->update(['status' => $request->status]);
        return redirect()->route('staff.approvals.index')->with('success', 'Loan status updated.');
    }
}
