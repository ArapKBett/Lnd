<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - WealthBuild Loans</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-900 to-purple-900 flex items-center justify-center min-h-screen py-12">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl mx-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Create Your Account</h2>
        <p class="text-gray-500 text-center mb-6">Join WealthBuild Loans and start your financial journey</p>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-purple-500" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-purple-500" required>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="+254..." class="w-full p-2 border rounded focus:ring-2 focus:ring-purple-500" required>
                </div>

                <div>
                    <label for="id_number" class="block text-sm font-medium text-gray-700 mb-1">ID Number</label>
                    <input type="text" name="id_number" id="id_number" value="{{ old('id_number') }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-purple-500">
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-purple-500">
                </div>

                <div>
                    <label for="mpesa_number" class="block text-sm font-medium text-gray-700 mb-1">M-Pesa Number</label>
                    <input type="text" name="mpesa_number" id="mpesa_number" value="{{ old('mpesa_number') }}" placeholder="+254..." class="w-full p-2 border rounded focus:ring-2 focus:ring-purple-500">
                </div>

                <div>
                    <label for="preferred_payment_method" class="block text-sm font-medium text-gray-700 mb-1">Preferred Payment</label>
                    <select name="preferred_payment_method" id="preferred_payment_method" class="w-full p-2 border rounded focus:ring-2 focus:ring-purple-500">
                        <option value="mpesa">M-Pesa</option>
                        <option value="crypto">Cryptocurrency</option>
                    </select>
                </div>

                <div>
                    <label for="crypto_address" class="block text-sm font-medium text-gray-700 mb-1">Crypto Address (Optional)</label>
                    <input type="text" name="crypto_address" id="crypto_address" value="{{ old('crypto_address') }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-purple-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-2 border rounded focus:ring-2 focus:ring-purple-500" required>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 border rounded focus:ring-2 focus:ring-purple-500" required>
                </div>
            </div>

            <button type="submit" class="w-full mt-6 bg-purple-600 text-white p-3 rounded font-semibold hover:bg-purple-700 transition-colors">
                Create Account
            </button>
        </form>

        <p class="text-center mt-4 text-gray-600">
            Already have an account? <a href="{{ route('login') }}" class="text-purple-600 hover:underline">Login</a>
        </p>
    </div>
</body>
</html>
