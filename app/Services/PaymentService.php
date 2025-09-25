<?php
namespace App\Services;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;

class PaymentService {
    public function processMpesaPayment($loanId, $amount, $phone, $transactionId) {
        return Payment::create([
            'loan_id' => $loanId,
            'amount' => $amount,
            'method' => 'mpesa',
            'transaction_id' => $transactionId,
        ]);
    }

    public function processCryptoPayment($loanId, $amount, $txid) {
        $verify = Http::withHeaders(['API-KEY' => env('COINREMITTER_API_KEY')])
            ->get('https://coinremitter.com/api/v3/get_transaction', ['txid' => $txid]);
        if ($verify->json()['success']) {
            return Payment::create([
                'loan_id' => $loanId,
                'amount' => $amount,
                'method' => 'crypto',
                'transaction_id' => $txid,
            ]);
        }
        throw new \Exception('Crypto payment verification failed.');
    }
}
