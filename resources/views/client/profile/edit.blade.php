@extends('layouts.client')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Edit Profile</h2>

        <form action="{{ route('client.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="mpesa_number" class="block text-sm font-medium text-gray-700 mb-1">M-Pesa Number</label>
                    <input type="text" name="mpesa_number" id="mpesa_number" value="{{ old('mpesa_number', $user->mpesa_number) }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="crypto_address" class="block text-sm font-medium text-gray-700 mb-1">Crypto Address</label>
                    <input type="text" name="crypto_address" id="crypto_address" value="{{ old('crypto_address', $user->crypto_address) }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="preferred_payment_method" class="block text-sm font-medium text-gray-700 mb-1">Preferred Payment Method</label>
                    <select name="preferred_payment_method" id="preferred_payment_method" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">
                        <option value="mpesa" {{ $user->preferred_payment_method == 'mpesa' ? 'selected' : '' }}>M-Pesa</option>
                        <option value="crypto" {{ $user->preferred_payment_method == 'crypto' ? 'selected' : '' }}>Cryptocurrency</option>
                    </select>
                </div>

                <div>
                    <label for="id_document" class="block text-sm font-medium text-gray-700 mb-1">ID Document (PDF, JPG, PNG)</label>
                    <input type="file" name="id_document" id="id_document" class="w-full p-2 border rounded" accept=".pdf,.jpg,.png">
                    @if($user->id_document)
                        <p class="text-sm text-green-600 mt-1">Document uploaded: {{ basename($user->id_document) }}</p>
                    @endif
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded font-semibold hover:bg-blue-700">
                    Update Profile
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mt-6">
        <h3 class="text-lg font-semibold mb-3">Account Summary</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-gray-500">Savings Balance:</span>
                <span class="font-semibold">KSh {{ number_format($user->savings_balance, 2) }}</span>
            </div>
            <div>
                <span class="text-gray-500">Loan Limit:</span>
                <span class="font-semibold">KSh {{ number_format($user->loan_limit, 2) }}</span>
            </div>
            <div>
                <span class="text-gray-500">Credit Score:</span>
                <span class="font-semibold">{{ $user->credit_score }}</span>
            </div>
            <div>
                <span class="text-gray-500">Member Since:</span>
                <span class="font-semibold">{{ $user->created_at->format('M d, Y') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
