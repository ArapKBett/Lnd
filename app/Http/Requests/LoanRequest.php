<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'client';
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:1000',
            'term_months' => 'required|integer|in:3,6,12,24',
            'interest_rate' => 'required|numeric|min:5|max:30',
            'purpose' => 'nullable|string',
            'savings_boost' => 'nullable|numeric|min:0',
        ];
    }
}
