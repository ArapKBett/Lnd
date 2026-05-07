<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - QuantumLoans</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-purple-900 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">QuantumLoans Admin</a>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-200">Dashboard</a>
                <a href="{{ route('admin.clients.index') }}" class="hover:text-purple-200">Clients</a>
                <a href="{{ route('admin.loans.index') }}" class="hover:text-purple-200">Loans</a>
                <a href="{{ route('admin.staff.index') }}" class="hover:text-purple-200">Staff</a>
                <a href="{{ route('admin.reports') }}" class="hover:text-purple-200">Reports</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-purple-200">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <main class="container mx-auto py-6 px-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        @yield('content')
    </main>
    <footer class="bg-black text-white text-center py-4">
        <p>&copy; {{ date('Y') }} QuantumLoans. Built by ARAP.</p>
    </footer>
</body>
</html>
