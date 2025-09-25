<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Loan;

class DashboardController extends Controller {
    public function index() {
        $loans = auth()->user()->loans()->with('payments')->get();
        $savings = auth()->user()->savings;
        return view('client.dashboard', compact('loans', 'savings'));
    }
}
