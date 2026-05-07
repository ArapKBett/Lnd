<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\LoanPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{
    public function stkPush(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'loan_payment_id' => 'required|exists:loan_payments,id',
        ]);

        try {
            $response = \Iankumu\Mpesa\Facades\Mpesa::stkpush(
                $validated['phone'],
                $validated['amount'],
                'WealthBuildLoan',
                'Loan Repayment'
            );

            return response()->json([
                'success' => true,
                'message' => 'STK push sent. Check your phone.',
                'data' => $response,
            ]);
        } catch (\Exception $e) {
            Log::error('M-Pesa STK Push failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Payment initiation failed. Please try again.',
            ], 500);
        }
    }

    public function callback(Request $request)
    {
        Log::info('M-Pesa Callback received', $request->all());

        $callbackData = $request->input('Body.stkCallback', []);
        $resultCode = $callbackData['ResultCode'] ?? 1;

        if ($resultCode == 0) {
            $metadata = collect($callbackData['CallbackMetadata']['Item'] ?? []);

            $amount = $metadata->firstWhere('Name', 'Amount')['Value'] ?? 0;
            $transactionId = $metadata->firstWhere('Name', 'MpesaReceiptNumber')['Value'] ?? '';
            $phone = $metadata->firstWhere('Name', 'PhoneNumber')['Value'] ?? '';

            $pendingPayment = LoanPayment::where('status', 'pending')
                ->where('amount', $amount)
                ->oldest('due_date')
                ->first();

            if ($pendingPayment) {
                $pendingPayment->markAsCompleted('mpesa', $transactionId);
                Log::info("Payment completed: Loan #{$pendingPayment->loan_id}, Amount: {$amount}");
            }
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
    }
}
