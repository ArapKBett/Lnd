<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest {
    public function authorize(): bool {
        return auth()->check() && auth()->user()->hasRole('client');
    }

    public function rules(): array {
        return [
            'amount' => 'required|numeric|min:1000|max:100000',
            'term_months' => 'required|integer|min:6|max:60',
            'interest_rate' => 'required|numeric|min:5|max:20',
            'savings_boost' => 'nullable|numeric|min:0',
        ];
    }
}
