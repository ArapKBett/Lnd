<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WealthBuild Loans</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gradient-to-br from-blue-900 to-purple-900 text-white">
    <header class="bg-black bg-opacity-50 py-4">
        <nav class="container mx-auto flex justify-between">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10">
            <a href="/login" class="bg-green-500 px-4 py-2 rounded">Login</a>
        </nav>
    </header>
    
    <section class="hero relative h-screen flex items-center justify-center overflow-hidden">
        <img src="{{ asset('images/landing-hero.jpg') }}" alt="Hero" class="absolute inset-0 w-full h-full object-cover opacity-70">
        <div class="relative z-10 text-center">
            <h1 class="text-6xl font-bold mb-4">Build Wealth, Borrow Smart</h1>
            <p class="text-xl mb-6">Savings boost your limits by 50%. Instant loans via M-Pesa & Crypto.</p>
            <a href="/login" class="bg-yellow-500 px-8 py-3 rounded-full text-lg">Get Started</a>
        </div>
    </section>
    
    <section class="services py-20 container mx-auto">
        <h2 class="text-4xl text-center mb-12">Our Services</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white bg-opacity-10 p-6 rounded-lg">
                <h3 class="text-2xl mb-4">Quick Loans</h3>
                <p>Apply in minutes, approve in hours.</p>
            </div>
            <div class="bg-white bg-opacity-10 p-6 rounded-lg">
                <h3 class="text-2xl mb-4">Savings Booster</h3>
                <p>Save to unlock higher limits & better rates.</p>
            </div>
            <div class="bg-white bg-opacity-10 p-6 rounded-lg">
                <h3 class="text-2xl mb-4">Secure Payments</h3>
                <p>M-Pesa STK & Crypto (BTC/USDT) integrated.</p>
            </div>
        </div>
    </section>
    
    <!-- 360° Loan Simulator Graphic -->
    <section class="py-20 bg-gray-800">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl mb-4">Simulate Your Loan Journey – 360° View</h2>
            <canvas id="loanChart" width="400" height="400"></canvas>  <!-- Circular progress chart -->
            <script>
                const ctx = document.getElementById('loanChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: { labels: ['Base Limit', 'Savings Boost'], datasets: [{ data: [10000, 5000], backgroundColor: ['#3B82F6', '#10B981'] }] },
                    options: { rotation: -90, circumference: 180 * Math.PI / 180 }  // Semi-circle for "360° feel"
                });
            </script>
            <!-- For true 360°: Use Pannellum JS library for image panorama of loan process stages -->
            <div id="panorama" style="width:100%;height:400px;"></div>
            <script src="https://cdn.pannellum.org/2.5/pannellum.js"></script>
            <link rel="stylesheet" href="https://cdn.pannellum.org/2.5/pannellum.css"/>
            <script>
                pannellum.viewer('panorama', { type: 'equirectangular', panorama: '{{ asset("images/360-loan.jpg") }}', autoLoad: true });  // Custom 360 image
            </script>
        </div>
    </section>
    
    <footer class="bg-black py-4 text-center">
        <p>&copy; 2025 WealthBuild Loans. Built by ARAP.</p>
    </footer>
</body>
</html>
