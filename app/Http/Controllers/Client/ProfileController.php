<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('client.profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
            'mpesa_number' => 'nullable|string|max:15',
            'crypto_address' => 'nullable|string|max:255',
            'preferred_payment_method' => 'nullable|in:mpesa,crypto',
            'id_document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $user = auth()->user();
        $user->update($request->only([
            'name', 'email', 'phone', 'address',
            'mpesa_number', 'crypto_address', 'preferred_payment_method'
        ]));

        if ($request->hasFile('id_document')) {
            $path = $request->file('id_document')->store('documents', 'public');
            $user->update(['id_document' => $path]);
        }

        return redirect()->route('client.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
