<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = auth()->user()->loans()->latest()->get();
        return view('client.loans.index', compact('loans'));
    }

    public function create()
    {
        return view('client.loans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000|max:' . auth()->user()->loan_limit,
            'term_months' => 'required|integer|in:3,6,12,24',
            'interest_rate' => 'required|numeric',
            'purpose' => 'required|string',
            'savings_boost' => 'nullable|numeric|min:0',
        ]);

        $boost = $request->has('savings_boost') ? floatval($validated['savings_boost']) : 0;

        Loan::create([
            'client_id' => auth()->id(),
            'amount' => $validated['amount'],
            'term_months' => $validated['term_months'],
            'interest_rate' => $validated['interest_rate'],
            'limit_boost' => $boost,
            'status' => 'pending',
        ]);

        return redirect()->route('client.loans.index')->with('success', 'Loan application submitted successfully!');
    }
}
