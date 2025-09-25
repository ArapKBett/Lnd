<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest {
    public function authorize(): bool {
        return auth()->check() && auth()->user()->hasRole('client');
    }

    public function rules(): array {
        return [
            'amount' => 'required|numeric|min:100',
            'method' => 'required|in:mpesa,crypto',
            'phone' => 'required_if:method,mpesa|regex:/^2547[0-9]{8}$/',
        ];
    }
}
