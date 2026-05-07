<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\LoanPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CryptoController extends Controller
{
    public function createPayment(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'loan_payment_id' => 'required|exists:loan_payments,id',
            'coin' => 'nullable|in:BTC,USDT',
        ]);

        try {
            $response = Http::withHeaders(['API-KEY' => config('crypto.api_key')])
                ->post('https://coinremitter.com/api/v3/create_transaction', [
                    'coin' => $validated['coin'] ?? 'BTC',
                    'amount' => $validated['amount'],
                    'order_id' => 'LP-' . $validated['loan_payment_id'] . '-' . uniqid(),
                    'notify_url' => route('crypto.webhook'),
                ]);

            $data = $response->json();

            if ($data['success'] ?? false) {
                return response()->json([
                    'success' => true,
                    'payment_url' => $data['data']['payment_url'],
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Could not create crypto payment.',
            ], 400);
        } catch (\Exception $e) {
            Log::error('Crypto payment creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Payment service unavailable.',
            ], 500);
        }
    }

    public function webhook(Request $request)
    {
        Log::info('Crypto webhook received', $request->all());

        $txid = $request->input('txid');
        $orderId = $request->input('order_id');

        if (!$txid || !$orderId) {
            return response()->json(['error' => 'Missing data'], 400);
        }

        try {
            $verify = Http::withHeaders(['API-KEY' => config('crypto.api_key')])
                ->get('https://coinremitter.com/api/v3/get_transaction', ['txid' => $txid]);

            $data = $verify->json();

            if ($data['success'] ?? false) {
                $parts = explode('-', $orderId);
                $paymentId = $parts[1] ?? null;

                if ($paymentId) {
                    $payment = LoanPayment::find($paymentId);
                    if ($payment && $payment->status === 'pending') {
                        $payment->markAsCompleted('crypto', $txid);
                        Log::info("Crypto payment completed: Loan Payment #{$paymentId}");
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Crypto webhook verification failed: ' . $e->getMessage());
        }

        return response()->json(['status' => 'ok']);
    }
}
