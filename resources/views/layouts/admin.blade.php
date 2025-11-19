<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - LoanEase Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-purple-900 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">LoanEase Pro Admin</a>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="mx-2">Dashboard</a>
                <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="mx-2">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </nav>
    <main class="container mx-auto py-6">
        @yield('content')
    </main>
    <footer class="bg-black text-white text-center py-4">
        <p>&copy; 2025 LoanEase Pro. Built by ARAP.</p>
    </footer>
</body>
</html>
