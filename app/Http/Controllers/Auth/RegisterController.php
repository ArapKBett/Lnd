<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:15'],
            'address' => ['nullable', 'string', 'max:500'],
            'id_number' => ['nullable', 'string', 'max:20'],
            'mpesa_number' => ['nullable', 'string', 'max:15'],
            'crypto_address' => ['nullable', 'string', 'max:255'],
            'preferred_payment_method' => ['nullable', 'in:mpesa,crypto'],
        ]);

        Role::firstOrCreate(['name' => 'client']);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'id_number' => $validated['id_number'] ?? null,
            'mpesa_number' => $validated['mpesa_number'] ?? null,
            'crypto_address' => $validated['crypto_address'] ?? null,
            'preferred_payment_method' => $validated['preferred_payment_method'] ?? 'mpesa',
            'role' => 'client',
            'credit_score' => 0,
            'savings_balance' => 0,
        ]);

        $user->assignRole('client');
        $user->calculateLoanLimit();

        Auth::login($user);

        return redirect()->route('client.dashboard');
    }
}
