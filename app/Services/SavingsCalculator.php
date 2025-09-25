<?php
namespace App\Services;
use App\Models\Savings;

class SavingsCalculator {
    public function calculateBoost($clientId): float {
        $savings = Savings::where('client_id', $clientId)->first();
        return $savings ? $savings->balance * 0.5 : 0; // 50% boost
    }
}
