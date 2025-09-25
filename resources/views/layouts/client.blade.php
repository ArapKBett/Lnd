<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client - WealthBuild Loans</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script defer src="{{ asset('js/app.js') }}"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-900 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <a href="{{ route('client.dashboard') }}">Client Dashboard</a>
            <div>
                <a href="{{ route('client.loans.index') }}" class="mx-2">Loans</a>
                <a href="{{ route('client.profile.edit') }}" class="mx-2">Profile</a>
                <a href="{{ route('logout') }}" class="mx-2">Logout</a>
            </div>
        </div>
    </nav>
    <main class="container mx-auto py-6">
        @yield('content')
    </main>
    <footer class="bg-black text-white text-center py-4">
        <p>&copy; 2025 WealthBuild Loans. Built by ARAP.</p>
    </footer>
</body>
</html>
