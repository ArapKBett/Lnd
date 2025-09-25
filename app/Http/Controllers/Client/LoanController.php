<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Services\LoanService;
use Illuminate\Http\Request;
use App\Http\Requests\LoanRequest;

class LoanController extends Controller {
    protected $loanService;
    public function __construct(LoanService $loanService) { $this->loanService = $loanService; }
    
    public function create() {
        $savingsBoost = auth()->user()->savings->boost ?? 0;
        return view('client.loans.create', compact('savingsBoost'));
    }
    
    public function store(LoanRequest $request) {
        $boostedAmount = $request->amount + ($request->savings_boost ?? 0);
        $loan = $this->loanService->createLoan(auth()->id(), $boostedAmount, $request->term_months, $request->interest_rate);
        return redirect()->route('client.loans.index')->with('success', 'Loan applied! Boosted by savings: KSh ' . $boostedAmount);
    }
    
    public function index() {
        $loans = auth()->user()->loans;
        return view('client.loans.index', compact('loans'));
    }
}
