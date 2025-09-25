<?php
namespace App\Services;
use App\Models\Loan;

class LoanService {
    public function createLoan($clientId, $amount, $term, $rate) {
        return Loan::create([
            'client_id' => $clientId,
            'amount' => $amount,
            'term_months' => $term,
            'interest_rate' => $rate,
            'limit_boost' => $amount - $amount * 0.5,  // Example boost calc
        ]);
    }
}
