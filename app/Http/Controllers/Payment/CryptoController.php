<?php
namespace App\Http\Controllers\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CryptoController extends Controller {
    public function createPayment(Request $request) {
        $response = Http::withHeaders(['API-KEY' => env('COINREMITTER_API_KEY')])
            ->post('https://coinremitter.com/api/v3/create_transaction', [
                'coin' => 'BTC',
                'amount' => $request->amount,
                'order_id' => uniqid(),
                'notify_url' => route('crypto.webhook'),
            ]);
        $data = $response->json();
        if ($data['success']) {
            // Store payment intent
            return redirect($data['data']['payment_url']);
        }
    }
    
    public function webhook(Request $request) {
        // Verify via API, update loan/payment
        $verify = Http::withHeaders(['API-KEY' => env('COINREMITTER_API_KEY')])
            ->get('https://coinremitter.com/api/v3/get_transaction', ['txid' => $request->txid]);
        // If confirmed, update status
    }
}
