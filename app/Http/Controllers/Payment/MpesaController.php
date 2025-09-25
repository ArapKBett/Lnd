<?php
namespace App\Http\Controllers\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Iankumu\Mpesa\Facades\Mpesa;  // From package

class MpesaController extends Controller {
    public function stkPush(Request $request) {
        $mpesa = Mpesa::stkpush((object)[
            'businessShortCode' => env('MPESA_SHORTCODE'),
            'password' => env('MPESA_PASSKEY'),
            'timestamp' => date('YmdHis'),
            'transactionType' => 'CustomerPayBillOnline',
            'amount' => $request->amount,
            'partyA' => $request->phone,
            'partyB' => env('MPESA_SHORTCODE'),
            'phoneNumber' => $request->phone,
            'callBackURL' => route('mpesa.callback'),
            'accountReference' => 'WealthBuildLoan',
            'transactionDesc' => 'Loan Repayment'
        ]);
        return response()->json($mpesa);
    }
    
    public function callback(Request $request) {
        // Process callback, update Payment model
        // Example: $payment = Payment::create([...]);
        return response('OK');
    }
}
