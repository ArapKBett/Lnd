<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoanDisbursementController extends Controller
{
    public function disburse(Loan $loan, Request $request)
    {
        $client = $loan->client;
        
        // Validate disbursement method
        $validated = $request->validate([
            'disbursement_method' => 'required|in:mpesa,crypto',
            'mpesa_number' => 'required_if:disbursement_method,mpesa',
            'crypto_address' => 'required_if:disbursement_method,crypto',
        ]);

        try {
            if ($validated['disbursement_method'] === 'mpesa') {
                $result = $this->disburseViaMpesa(
                    $validated['mpesa_number'] ?? $client->mpesa_number,
                    $loan->amount
                );
            } else {
                $result = $this->disburseViaCrypto(
                    $validated['crypto_address'] ?? $client->crypto_address,
                    $loan->amount
                );
            }

            if ($result['success']) {
                // Update loan status
                $loan->update([
                    'status' => 'disbursed',
                    'disbursement_method' => $validated['disbursement_method'],
                    'disbursement_reference' => $result['reference'],
                    'disbursement_date' => now(),
                    'remaining_balance' => $loan->amount,
                ]);

                // Generate payment schedule
                $loan->calculateMonthlyPayment();
                $loan->generatePaymentSchedule();

                return back()->with('success', 'Loan disbursed successfully. Reference: '.$result['reference']);
            } else {
                return back()->with('error', 'Disbursement failed: '.$result['message']);
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Disbursement error: '.$e->getMessage());
        }
    }

    private function disburseViaMpesa($phone, $amount)
    {
        // Integrate with M-Pesa API
        // This is a mock implementation - replace with actual M-Pesa API calls
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.env('MPESA_ACCESS_TOKEN'),
            'Content-Type' => 'application/json',
        ])->post(env('MPESA_DISBURSEMENT_URL'), [
            'phone' => $phone,
            'amount' => $amount,
            'reference' => 'LOAN_'.time(),
        ]);

        if ($response->successful()) {
            return [
                'success' => true,
                'reference' => $response->json()['reference'],
                'message' => 'Disbursement initiated successfully'
            ];
        }

        return [
            'success' => false,
            'message' => $response->json()['error'] ?? 'M-Pesa disbursement failed'
        ];
    }

    private function disburseViaCrypto($address, $amount)
    {
        // Integrate with cryptocurrency API
        // This is a mock implementation - replace with actual crypto API calls
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.env('CRYPTO_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('CRYPTO_DISBURSEMENT_URL'), [
            'address' => $address,
            'amount' => $amount,
            'currency' => 'USDT', // or preferred cryptocurrency
        ]);

        if ($response->successful()) {
            return [
                'success' => true,
                'reference' => $response->json()['tx_hash'],
                'message' => 'Crypto transfer initiated successfully'
            ];
        }

        return [
            'success' => false,
            'message' => $response->json()['error'] ?? 'Crypto transfer failed'
        ];
    }
}
