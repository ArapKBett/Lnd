<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - WealthBuild Loans</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-900 to-purple-900 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm">Email</label>
                <input type="email" name="email" id="email" class="w-full p-2 border rounded" required>
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm">Password</label>
                <input type="password" name="password" id="password" class="w-full p-2 border rounded" required>
            </div>
            <button type="submit" class="w-full bg-green-500 text-white p-2 rounded">Login</button>
        </form>
    </div>
    <footer class="absolute bottom-0 w-full bg-black text-white text-center py-4">
        <p>&copy; 2025 WealthBuild Loans. Built by ARAP.</p>
    </footer>
</body>
</html>
