<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff - WealthBuild Loans</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script defer src="{{ asset('js/app.js') }}"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-900 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <a href="{{ route('staff.dashboard') }}">Staff Dashboard</a>
            <div>
                <a href="{{ route('staff.approvals.index') }}" class="mx-2">Approvals</a>
                <a href="{{ route('staff.reports.index') }}" class="mx-2">Reports</a>
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
