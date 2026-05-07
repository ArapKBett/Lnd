<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuantumLoans | Next-Gen Financial Solutions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            position: relative;
            overflow: hidden;
        }
        
        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(16, 185, 129, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(147, 51, 234, 0.1) 0%, transparent 50%);
            z-index: 1;
        }
        
        .content-wrapper {
            position: relative;
            z-index: 2;
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .neon-glow {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
        }
        
        .chart-container {
            position: relative;
            height: 400px;
        }
        
        .panorama-container {
            width: 100%;
            height: 500px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body class="gradient-bg text-white">
    <!-- Security Headers -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdn.tailwindcss.com https://unpkg.com https://cdn.jsdelivr.net https://cdn.pannellum.org; style-src 'self' https://fonts.googleapis.com https://cdn.pannellum.org; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; img-src 'self' data:; connect-src 'self'; frame-src 'none'; object-src 'none';">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="X-XSS-Protection" content="1; mode=block">
    
    <div class="content-wrapper">
        <!-- Header with Security Indicators -->
        <header class="bg-black bg-opacity-30 backdrop-blur-md fixed w-full top-0 z-50 py-4">
            <nav class="container mx-auto px-4 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">QuantumLoans</span>
                </div>
                
                <div class="flex items-center space-x-6">
                    <!-- Security Status Indicator -->
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full pulse"></div>
                        <span class="text-sm font-medium">Secure Connection</span>
                        <i class="fas fa-shield-alt text-green-400"></i>
                    </div>
                    
                    <a href="/login" class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-2 rounded-full font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-300 neon-glow">
                        Secure Login
                    </a>
                </div>
            </nav>
        </header>
        
        <!-- Hero Section with 360° Financial Visualization -->
        <section class="hero min-h-screen flex items-center justify-center pt-20">
            <div class="container mx-auto px-4 grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <div class="space-y-6">
                        <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                            <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">Quantum Financial Solutions</span>
                        </h1>
                        <p class="text-xl lg:text-2xl text-gray-300 font-light">
                            AI-Powered Lending • Blockchain Security • Instant Global Transactions
                        </p>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="/login" class="bg-gradient-to-r from-blue-500 to-purple-600 px-8 py-4 rounded-full font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-300 neon-glow inline-flex items-center space-x-2">
                                <i class="fas fa-rocket"></i>
                                <span>Launch Your Financial Journey</span>
                            </a>
                            
                            <a href="#features" class="bg-transparent border-2 border-blue-400 text-blue-400 px-8 py-4 rounded-full font-semibold hover:bg-blue-400 hover:text-white transition-all duration-300 inline-flex items-center space-x-2">
                                <i class="fas fa-play"></i>
                                <span>See How It Works</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Real-time Financial Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12">
                        <div class="glass-effect p-6 rounded-xl text-center">
                            <div class="text-3xl font-bold bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                                <span id="total-loans">12,487</span>+
                            </div>
                            <div class="text-sm text-gray-400 mt-2">Loans Processed</div>
                        </div>
                        
                        <div class="glass-effect p-6 rounded-xl text-center">
                            <div class="text-3xl font-bold bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">
                                $<span id="total-volume">48.7M</span>+
                            </div>
                            <div class="text-sm text-gray-400 mt-2">Transaction Volume</div>
                        </div>
                        
                        <div class="glass-effect p-6 rounded-xl text-center">
                            <div class="text-3xl font-bold bg-gradient-to-r from-purple-400 to-pink-500 bg-clip-text text-transparent">
                                <span id="active-users">8,241</span>+
                            </div>
                            <div class="text-sm text-gray-400 mt-2">Active Users</div>
                        </div>
                    </div>
                </div>
                
                <!-- 360° Financial Visualization -->
                <div class="panorama-container floating-animation">
                    <div id="financial-panorama"></div>
                </div>
            </div>
        </section>
        
        <!-- Interactive Loan Simulator -->
        <section id="features" class="py-20">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl lg:text-5xl font-bold mb-6">
                        <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">360° Financial Ecosystem</span>
                    </h2>
                    <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                        Experience our immersive financial platform with real-time analytics, AI-driven insights, and blockchain security
                    </p>
                </div>
                
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Interactive Chart -->
                    <div class="chart-container glass-effect rounded-xl p-6">
                        <canvas id="loanEcosystemChart"></canvas>
                    </div>
                    
                    <!-- Feature Cards -->
                    <div class="space-y-6">
                        <div class="glass-effect p-6 rounded-xl hover:scale-105 transition-all duration-300">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-bolt text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold mb-2">Instant Approval Engine</h3>
                                    <p class="text-gray-300">AI-powered credit scoring with 99.7% accuracy. Get approved in under 60 seconds.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="glass-effect p-6 rounded-xl hover:scale-105 transition-all duration-300">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-shield-alt text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold mb-2">Quantum Security</h3>
                                    <p class="text-gray-300">Military-grade encryption with biometric authentication and real-time fraud detection.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="glass-effect p-6 rounded-xl hover:scale-105 transition-all duration-300">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-globe text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold mb-2">Global Transaction Network</h3>
                                    <p class="text-gray-300">Instant cross-border transactions with 0.1% fees. Support for 150+ currencies and cryptocurrencies.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Advanced Analytics Section -->
        <section class="py-20">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl lg:text-5xl font-bold mb-6">
                        <span class="bg-gradient-to-r from-emerald-400 to-teal-500 bg-clip-text text-transparent">Real-Time Financial Intelligence</span>
                    </h2>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Market Trends -->
                    <div class="glass-effect p-6 rounded-xl">
                        <h3 class="text-xl font-semibold mb-4 flex items-center">
                            <i class="fas fa-chart-line mr-2 text-blue-400"></i>
                            Market Trends
                        </h3>
                        <canvas id="marketTrendsChart" height="200"></canvas>
                        <div class="mt-4 text-center">
                            <div class="text-2xl font-bold bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">
                                +12.8% <i class="fas fa-arrow-up text-green-400"></i>
                            </div>
                            <div class="text-sm text-gray-400">30-Day Growth</div>
                        </div>
                    </div>
                    
                    <!-- Risk Assessment -->
                    <div class="glass-effect p-6 rounded-xl">
                        <h3 class="text-xl font-semibold mb-4 flex items-center">
                            <i class="fas fa-shield-virus mr-2 text-purple-400"></i>
                            Risk Assessment
                        </h3>
                        <canvas id="riskChart" height="200"></canvas>
                        <div class="mt-4 text-center">
                            <div class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-pink-500 bg-clip-text text-transparent">
                                92.4/100
                            </div>
                            <div class="text-sm text-gray-400">Platform Security Score</div>
                        </div>
                    </div>
                    
                    <!-- Global Reach -->
                    <div class="glass-effect p-6 rounded-xl">
                        <h3 class="text-xl font-semibold mb-4 flex items-center">
                            <i class="fas fa-earth-americas mr-2 text-teal-400"></i>
                            Global Reach
                        </h3>
                        <div class="flex justify-center mb-4">
                            <div class="relative w-32 h-32">
                                <svg viewBox="0 0 100 100" class="w-full h-full transform -rotate-90">
                                    <circle cx="50" cy="50" r="40" fill="transparent" stroke="rgba(255,255,255,0.1)" stroke-width="8"/>
                                    <circle cx="50" cy="50" r="40" fill="transparent" stroke="url(#gradient)" stroke-width="8" 
                                            stroke-dasharray="251.2" stroke-dashoffset="75.36" stroke-linecap="round"/>
                                    <defs>
                                        <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                            <stop offset="0%" style="stop-color:#10B981;stop-opacity:1" />
                                            <stop offset="100%" style="stop-color:#06B6D4;stop-opacity:1" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-2xl font-bold">78%</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-semibold">Global Coverage</div>
                            <div class="text-sm text-gray-400">124 Countries Served</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Testimonials with 3D Effect -->
        <section class="py-20">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl lg:text-5xl font-bold mb-6">
                        <span class="bg-gradient-to-r from-purple-400 to-pink-500 bg-clip-text text-transparent">Trusted by Financial Leaders</span>
                    </h2>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="glass-effect p-8 rounded-xl transform hover:rotate-3 hover:scale-105 transition-all duration-500">
                        <div class="text-6xl text-blue-400 mb-4">"</div>
                        <p class="text-gray-300 mb-6">QuantumLoans transformed our financial operations. The AI-driven insights and real-time analytics have increased our efficiency by 40%.</p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mr-4"></div>
                            <div>
                                <div class="font-semibold">Sarah Johnson</div>
                                <div class="text-sm text-gray-400">CFO, TechCorp</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="glass-effect p-8 rounded-xl transform hover:rotate-3 hover:scale-105 transition-all duration-500">
                        <div class="text-6xl text-green-400 mb-4">"</div>
                        <p class="text-gray-300 mb-6">The security features are unparalleled. We've eliminated fraud completely since switching to QuantumLoans' quantum encryption.</p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full mr-4"></div>
                            <div>
                                <div class="font-semibold">Michael Chen</div>
                                <div class="text-sm text-gray-400">Security Director, GlobalBank</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="glass-effect p-8 rounded-xl transform hover:rotate-3 hover:scale-105 transition-all duration-500">
                        <div class="text-6xl text-purple-400 mb-4">"</div>
                        <p class="text-gray-300 mb-6">Our customers love the instant approval and global transaction capabilities. It's like having a financial superpower.</p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full mr-4"></div>
                            <div>
                                <div class="font-semibold">Emily Rodriguez</div>
                                <div class="text-sm text-gray-400">CEO, FinTech Innovations</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Final CTA with Robotic Elegance -->
        <section class="py-20 text-center">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <div class="mb-8">
                        <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mx-auto mb-6 flex items-center justify-center">
                            <i class="fas fa-robot text-white text-3xl"></i>
                        </div>
                    </div>
                    
                    <h2 class="text-4xl lg:text-5xl font-bold mb-6">
                        Experience the Future of Finance
                    </h2>
                    
                    <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                        Join thousands of businesses and individuals who are revolutionizing their financial journey with QuantumLoans' AI-powered platform.
                    </p>
                    
                    <div class="flex flex-wrap justify-center gap-4 mb-12">
                        <a href="/register" class="bg-gradient-to-r from-blue-500 to-purple-600 px-8 py-4 rounded-full font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-300 neon-glow inline-flex items-center space-x-2">
                            <i class="fas fa-user-plus"></i>
                            <span>Create Account</span>
                        </a>
                        
                        <a href="/login" class="bg-transparent border-2 border-purple-400 text-purple-400 px-8 py-4 rounded-full font-semibold hover:bg-purple-400 hover:text-white transition-all duration-300 inline-flex items-center space-x-2">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login to Dashboard</span>
                        </a>
                    </div>
                    
                    <!-- Security Badges -->
                    <div class="flex flex-wrap justify-center gap-6 text-sm">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-green-400"></i>
                            <span>ISO 27001 Certified</span>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-green-400"></i>
                            <span>PCI DSS Compliant</span>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-green-400"></i>
                            <span>GDPR Compliant</span>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-green-400"></i>
                            <span>256-bit Encryption</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Footer with Comprehensive Information -->
        <footer class="bg-black bg-opacity-40 backdrop-blur-md py-16">
            <div class="container mx-auto px-4">
                <div class="grid md:grid-cols-4 gap-8 mb-12">
                    <div>
                        <div class="flex items-center space-x-2 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-chart-line text-white text-xl"></i>
                            </div>
                            <span class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">QuantumLoans</span>
                        </div>
                        
                        <p class="text-gray-400 mb-6">Revolutionizing global finance with AI-powered lending and quantum security.</p>
                        
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center hover:scale-110 transition-transform">
                                <i class="fab fa-facebook-f text-white"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center hover:scale-110 transition-transform">
                                <i class="fab fa-twitter text-white"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center hover:scale-110 transition-transform">
                                <i class="fab fa-linkedin-in text-white"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center hover:scale-110 transition-transform">
                                <i class="fab fa-instagram text-white"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Products</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">AI Lending</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Quantum Security</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Global Payments</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Financial Analytics</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Blockchain Solutions</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Resources</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">Documentation</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">API Reference</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Developer Portal</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Security Center</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Compliance</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Legal</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Cookie Policy</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Security Policy</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Responsible Disclosure</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-gray-700 pt-8 flex flex-wrap justify-between items-center">
                    <div class="text-gray-400 text-sm">
                        © 2025 QuantumLoans. All rights reserved.
                    </div>
                    
                    <div class="flex space-x-6 text-sm text-gray-400">
                        <a href="#" class="hover:text-white transition-colors">Contact Us</a>
                        <a href="#" class="hover:text-white transition-colors">Careers</a>
                        <a href="#" class="hover:text-white transition-colors">Press</a>
                        <a href="#" class="hover:text-white transition-colors">Status</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- JavaScript Libraries -->
    <script src="https://cdn.pannellum.org/2.5/pannellum.js"></script>
    <link rel="stylesheet" href="https://cdn.pannellum.org/2.5/pannellum.css"/>
    
    <!-- Initialize 360° Panorama -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize financial panorama
            if (document.getElementById('financial-panorama')) {
                pannellum.viewer('financial-panorama', {
                    type: 'equirectangular',
                    panorama: '{{ asset("images/financial-360.jpg") }}',
                    autoLoad: true,
                    autoRotate: -2,
                    showZoomCtrl: false,
                    showFullscreenCtrl: false,
                    compass: true
                });
            }
            
            // Animate counters
            function animateCounter(element, target) {
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;
                
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        element.textContent = target.toLocaleString();
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(current).toLocaleString();
                    }
                }, 16);
            }
            
            const totalLoans = document.getElementById('total-loans');
            const totalVolume = document.getElementById('total-volume');
            const activeUsers = document.getElementById('active-users');
            
            if (totalLoans) animateCounter(totalLoans, 12487);
            if (totalVolume) animateCounter(totalVolume, 487);
            if (activeUsers) animateCounter(activeUsers, 8241);
            
            // Initialize Charts
            const loanEcosystemCtx = document.getElementById('loanEcosystemChart');
            if (loanEcosystemCtx) {
                new Chart(loanEcosystemCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['AI Lending', 'Quantum Security', 'Global Payments', 'Analytics', 'Blockchain'],
                        datasets: [{
                            data: [35, 20, 15, 20, 10],
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.8)',
                                'rgba(16, 185, 129, 0.8)',
                                'rgba(147, 51, 234, 0.8)',
                                'rgba(239, 68, 68, 0.8)',
                                'rgba(251, 146, 60, 0.8)'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: 'white',
                                    padding: 15,
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // Market Trends Chart
            const marketTrendsCtx = document.getElementById('marketTrendsChart');
            if (marketTrendsCtx) {
                const gradient = marketTrendsCtx.createLinearGradient(0, 0, 0, 200);
                gradient.addColorStop(0, 'rgba(16, 185, 129, 0.3)');
                gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');
                
                new Chart(marketTrendsCtx, {
                    type: 'line',
                    data: {
                        labels: Array.from({length: 30}, (_, i) => i + 1),
                        datasets: [{
                            label: 'Market Growth',
                            data: Array.from({length: 30}, () => Math.random() * 20 + 80),
                            borderColor: 'rgba(16, 185, 129, 1)',
                            backgroundColor: gradient,
                            tension: 0.4,
                            fill: true,
                            borderWidth: 2,
                            pointRadius: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: false,
                                ticks: { color: 'white' },
                                grid: { color: 'rgba(255, 255, 255, 0.1)' }
                            },
                            x: {
                                ticks: { color: 'white' },
                                grid: { color: 'rgba(255, 255, 255, 0.1)' }
                            }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            }
            
            // Risk Assessment Chart
            const riskCtx = document.getElementById('riskChart');
            if (riskCtx) {
                new Chart(riskCtx, {
                    type: 'radar',
                    data: {
                        labels: ['Security', 'Compliance', 'Fraud Detection', 'Data Protection', 'Encryption'],
                        datasets: [{
                            label: 'Risk Score',
                            data: [95, 90, 98, 92, 97],
                            backgroundColor: 'rgba(147, 51, 234, 0.2)',
                            borderColor: 'rgba(147, 51, 234, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(147, 51, 234, 1)'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            r: {
                                angleLines: { color: 'rgba(255, 255, 255, 0.2)' },
                                grid: { color: 'rgba(255, 255, 255, 0.1)' },
                                ticks: { 
                                    stepSize: 20,
                                    color: 'white',
                                    backdropColor: 'transparent'
                                },
                                pointLabels: { color: 'white' }
                            }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            }
            
            // Add floating animation to cards
            const cards = document.querySelectorAll('.floating-animation');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.5}s`;
            });
        });
    </script>
    
    <!-- Additional Security Scripts -->
    <script>
        // Content Security Policy reporting
        document.addEventListener('securitypolicyviolation', function(e) {
            console.error('Security Policy Violation:', e);
        });
        
        // Clickjacking protection
        if (self !== top) {
            top.location = self.location;
        }
    </script>
</body>
</html>
