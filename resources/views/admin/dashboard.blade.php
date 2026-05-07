@extends('layouts.admin')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    
    body {
        font-family: 'Inter', sans-serif;
    }
    
    .admin-dashboard {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }
    
    .card-hover {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    .security-status {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .5; }
    }
    
    .chart-container {
        position: relative;
        height: 300px;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
    }
    
    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }
    
    .real-time-updates {
        border-left: 3px solid #3b82f6;
        padding-left: 15px;
    }
</style>

<div class="admin-dashboard min-h-screen p-6">
    <!-- Security Header with Real-time Monitoring -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-700 text-white rounded-xl p-6 mb-6 shadow-lg">
        <div class="flex flex-wrap justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">QuantumLoans Admin Dashboard</h1>
                <p class="text-blue-100">Real-time financial intelligence and security monitoring</p>
            </div>
            
            <div class="flex items-center space-x-6">
                <!-- Security Status -->
                <div class="flex items-center space-x-3">
                    <div class="w-4 h-4 bg-green-400 rounded-full security-status"></div>
                    <div>
                        <div class="text-sm font-medium">System Security</div>
                        <div class="text-xs text-blue-100">All systems operational</div>
                    </div>
                </div>
                
                <!-- Active Users -->
                <div class="flex items-center space-x-3">
                    <div class="w-4 h-4 bg-yellow-400 rounded-full animate-pulse"></div>
                    <div>
                        <div class="text-sm font-medium">{{ $stats['active_users'] ?? '0' }} Active Users</div>
                        <div class="text-xs text-blue-100">Real-time monitoring</div>
                    </div>
                </div>
                
                <!-- Last Backup -->
                <div class="flex items-center space-x-3">
                    <i class="fas fa-database"></i>
                    <div>
                        <div class="text-sm font-medium">Last Backup</div>
                        <div class="text-xs text-blue-100">{{ $stats['last_backup'] ?? 'Never' }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="mt-6 flex flex-wrap gap-3">
            <button class="bg-white text-blue-600 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition-colors inline-flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Add Staff
            </button>
            <button class="bg-white text-blue-600 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition-colors inline-flex items-center">
                <i class="fas fa-file-export mr-2"></i>
                Export Data
            </button>
            <button class="bg-white text-blue-600 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition-colors inline-flex items-center">
                <i class="fas fa-shield-alt mr-2"></i>
                Security Audit
            </button>
            <button class="bg-white text-blue-600 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition-colors inline-flex items-center">
                <i class="fas fa-cog mr-2"></i>
                System Settings
            </button>
        </div>
    </div>
    
    <!-- Comprehensive Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-6 mb-6">
        <!-- Total Clients -->
        <div class="bg-white p-6 rounded-xl shadow-md card-hover border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Clients</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_clients'] ?? 0) }}</div>
                    <div class="text-sm text-green-500 mt-1">
                        <i class="fas fa-arrow-up"></i> {{ $stats['client_growth'] ?? '0' }}% vs last month
                    </div>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Staff -->
        <div class="bg-white p-6 rounded-xl shadow-md card-hover border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Staff Members</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_staff'] ?? 0) }}</div>
                    <div class="text-sm text-green-500 mt-1">
                        <i class="fas fa-arrow-up"></i> {{ $stats['staff_growth'] ?? '0' }}% vs last month
                    </div>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-tie text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Loans -->
        <div class="bg-white p-6 rounded-xl shadow-md card-hover border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Loans</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_loans'] ?? 0) }}</div>
                    <div class="text-sm text-green-500 mt-1">
                        <i class="fas fa-arrow-up"></i> {{ $stats['loan_growth'] ?? '0' }}% vs last month
                    </div>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-hand-holding-usd text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Savings -->
        <div class="bg-white p-6 rounded-xl shadow-md card-hover border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Savings</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">KSh {{ number_format($stats['total_savings'] ?? 0, 2) }}</div>
                    <div class="text-sm text-green-500 mt-1">
                        <i class="fas fa-arrow-up"></i> {{ $stats['savings_growth'] ?? '0' }}% vs last month
                    </div>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-piggy-bank text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Revenue -->
        <div class="bg-white p-6 rounded-xl shadow-md card-hover border-l-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Revenue</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">KSh {{ number_format($stats['total_revenue'] ?? 0, 2) }}</div>
                    <div class="text-sm text-green-500 mt-1">
                        <i class="fas fa-arrow-up"></i> {{ $stats['revenue_growth'] ?? '0' }}% vs last month
                    </div>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-indigo-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Security Score -->
        <div class="bg-white p-6 rounded-xl shadow-md card-hover border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Security Score</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['security_score'] ?? '95' }}/100</div>
                    <div class="text-sm text-green-500 mt-1">
                        <i class="fas fa-shield-alt"></i> Excellent
                    </div>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shield-alt text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Left Column - Charts and Analytics -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Comprehensive Loan Analytics -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Loan Portfolio Analytics</h2>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded-full">7D</button>
                        <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-full">30D</button>
                        <button class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded-full">90D</button>
                        <button class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded-full">1Y</button>
                    </div>
                </div>
                
                <div class="chart-container">
                    <canvas id="loanTrendsChart"></canvas>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                    <div class="text-center p-3 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['pending_loans'] ?? '0' }}</div>
                        <div class="text-sm text-gray-600 mt-1">Pending</div>
                        <div class="text-xs text-gray-500">{{ $stats['pending_percentage'] ?? '0' }}% of total</div>
                    </div>
                    
                    <div class="text-center p-3 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['approved_loans'] ?? '0' }}</div>
                        <div class="text-sm text-gray-600 mt-1">Approved</div>
                        <div class="text-xs text-gray-500">{{ $stats['approved_percentage'] ?? '0' }}% of total</div>
                    </div>
                    
                    <div class="text-center p-3 bg-red-50 rounded-lg">
                        <div class="text-2xl font-bold text-red-600">{{ $stats['rejected_loans'] ?? '0' }}</div>
                        <div class="text-sm text-gray-600 mt-1">Rejected</div>
                        <div class="text-xs text-gray-500">{{ $stats['rejected_percentage'] ?? '0' }}% of total</div>
                    </div>
                    
                    <div class="text-center p-3 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">KSh {{ number_format($stats['total_loan_amount'] ?? 0, 2) }}</div>
                        <div class="text-sm text-gray-600 mt-1">Total Amount</div>
                        <div class="text-xs text-gray-500">Avg: KSh {{ number_format($stats['avg_loan_amount'] ?? 0, 2) }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Advanced Security Dashboard -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Security Monitoring Center</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">Last updated: {{ now()->format('H:i:s') }}</span>
                        <button class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Login Activity -->
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-3">Recent Login Activity</h3>
                        <div class="space-y-3">
                            @foreach($recent_logins as $login)
                            <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg">
                                <div class="user-avatar" style="background-color: {{ $login->avatar_color }}">
                                    {{ strtoupper(substr($login->username, 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-sm">{{ $login->username }}</div>
                                    <div class="text-xs text-gray-500">{{ $login->ip_address }}</div>
                                </div>
                                <div class="text-xs text-gray-500">{{ $login->created_at->diffForHumans() }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Security Alerts -->
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-3">Security Alerts</h3>
                        <div class="space-y-3">
                            @foreach($security_alerts as $alert)
                            <div class="flex items-start space-x-3 p-2 {{ $alert->severity === 'high' ? 'bg-red-50' : ($alert->severity === 'medium' ? 'bg-yellow-50' : 'bg-green-50') }} rounded-lg">
                                <div class="mt-1">
                                    @if($alert->severity === 'high')
                                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                                    @elseif($alert->severity === 'medium')
                                    <i class="fas fa-exclamation-circle text-yellow-500"></i>
                                    @else
                                    <i class="fas fa-check-circle text-green-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-medium text-sm">{{ $alert->title }}</div>
                                    <div class="text-xs text-gray-600">{{ $alert->description }}</div>
                                    <div class="text-xs text-gray-400 mt-1">{{ $alert->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- System Health -->
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-3">System Health</h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Database</span>
                                    <span class="font-semibold">{{ $system_health['database'] ?? '98' }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $system_health['database'] ?? '98' }}%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>API Response</span>
                                    <span class="font-semibold">{{ $system_health['api_response'] ?? '245' }}ms</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ min(100, (300 - ($system_health['api_response'] ?? 245)) / 3) }}%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Server Load</span>
                                    <span class="font-semibold">{{ $system_health['server_load'] ?? '12' }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $system_health['server_load'] ?? '12' }}%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Uptime</span>
                                    <span class="font-semibold">{{ $system_health['uptime'] ?? '99.9' }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $system_health['uptime'] ?? '99.9' }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Financial Performance Overview -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Financial Performance Overview</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                    
                    <div class="chart-container">
                        <canvas id="expenseChart"></canvas>
                    </div>
                </div>
                
                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-bold text-green-600">KSh {{ number_format($financials['gross_profit'] ?? 0, 2) }}</div>
                        <div class="text-sm text-gray-600 mt-1">Gross Profit</div>
                    </div>
                    
                    <div>
                        <div class="text-2xl font-bold text-blue-600">KSh {{ number_format($financials['net_profit'] ?? 0, 2) }}</div>
                        <div class="text-sm text-gray-600 mt-1">Net Profit</div>
                    </div>
                    
                    <div>
                        <div class="text-2xl font-bold text-purple-600">{{ $financials['profit_margin'] ?? '0' }}%</div>
                        <div class="text-sm text-gray-600 mt-1">Profit Margin</div>
                    </div>
                    
                    <div>
                        <div class="text-2xl font-bold text-indigo-600">{{ $financials['roi'] ?? '0' }}%</div>
                        <div class="text-sm text-gray-600 mt-1">ROI</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Real-time Monitoring and Staff Management -->
        <div class="space-y-6">
            <!-- Real-time Activity Feed -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Real-time Activity</h2>
                    <span class="text-sm text-gray-500">Updated every 5 seconds</span>
                </div>
                
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @foreach($real_time_activity as $activity)
                    <div class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-lg real-time-updates">
                        <div class="user-avatar" style="background-color: {{ $activity->avatar_color }}">
                            {{ strtoupper(substr($activity->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="font-medium text-sm">{{ $activity->user->name }}</div>
                                    <div class="text-xs text-gray-600">{{ $activity->description }}</div>
                                </div>
                                <div class="text-xs text-gray-400 ml-4">{{ $activity->created_at->diffForHumans() }}</div>
                            </div>
                            
                            @if($activity->details)
                            <div class="text-xs text-blue-600 mt-1">
                                <i class="fas fa-info-circle"></i> {{ $activity->details }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Staff Performance Dashboard -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Staff Performance</h2>
                    <a href="{{ route('admin.staff.index') }}" class="text-blue-600 text-sm hover:text-blue-800">View All</a>
                </div>
                
                <div class="space-y-4">
                    @foreach($top_performers as $staff)
                    <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg">
                        <div class="user-avatar" style="background-color: {{ $staff->avatar_color }}">
                            {{ strtoupper(substr($staff->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-sm">{{ $staff->name }}</div>
                            <div class="text-xs text-gray-500">{{ $staff->role }}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold text-sm">{{ $staff->performance_score }}%</div>
                            <div class="text-xs text-gray-500">{{ $staff->loans_processed }} loans</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-4 pt-4 border-t">
                    <div class="text-sm font-medium mb-2">Performance Metrics</div>
                    <div class="flex justify-between text-xs text-gray-600">
                        <div class="text-center">
                            <div class="font-semibold text-green-600">{{ $staff_stats['avg_performance'] ?? '0' }}%</div>
                            <div>Avg Performance</div>
                        </div>
                        <div class="text-center">
                            <div class="font-semibold text-blue-600">{{ $staff_stats['total_loans'] ?? '0' }}</div>
                            <div>Loans Processed</div>
                        </div>
                        <div class="text-center">
                            <div class="font-semibold text-purple-600">{{ $staff_stats['avg_response'] ?? '0' }}h</div>
                            <div>Avg Response</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Access -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Access</h2>
                
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.clients.index') }}" class="flex flex-col items-center justify-center p-3 hover:bg-blue-50 rounded-lg transition-colors">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                        <div class="text-sm font-medium">Clients</div>
                    </a>
                    
                    <a href="{{ route('admin.loans.index') }}" class="flex flex-col items-center justify-center p-3 hover:bg-green-50 rounded-lg transition-colors">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mb-2">
                            <i class="fas fa-hand-holding-usd text-green-600"></i>
                        </div>
                        <div class="text-sm font-medium">Loans</div>
                    </a>
                    
                    <a href="{{ route('admin.reports') }}" class="flex flex-col items-center justify-center p-3 hover:bg-purple-50 rounded-lg transition-colors">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mb-2">
                            <i class="fas fa-chart-bar text-purple-600"></i>
                        </div>
                        <div class="text-sm font-medium">Reports</div>
                    </a>
                    
                    <a href="{{ route('admin.security') }}" class="flex flex-col items-center justify-center p-3 hover:bg-red-50 rounded-lg transition-colors">
                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mb-2">
                            <i class="fas fa-shield-alt text-red-600"></i>
                        </div>
                        <div class="text-sm font-medium">Security</div>
                    </a>
                    
                    <a href="{{ route('admin.settings') }}" class="flex flex-col items-center justify-center p-3 hover:bg-indigo-50 rounded-lg transition-colors">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mb-2">
                            <i class="fas fa-cog text-indigo-600"></i>
                        </div>
                        <div class="text-sm font-medium">Settings</div>
                    </a>
                    
                    <a href="{{ route('admin.audit') }}" class="flex flex-col items-center justify-center p-3 hover:bg-yellow-50 rounded-lg transition-colors">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mb-2">
                            <i class="fas fa-clipboard-list text-yellow-600"></i>
                        </div>
                        <div class="text-sm font-medium">Audit Log</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Comprehensive Data Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Loan Applications -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Recent Loan Applications</h2>
                <a href="{{ route('admin.loans.index') }}" class="text-blue-600 text-sm hover:text-blue-800">View All</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm text-gray-500 uppercase tracking-wide">
                            <th class="pb-3">Client</th>
                            <th class="pb-3">Amount</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Date</th>
                            <th class="pb-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recent_loans as $loan)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3">
                                <div class="flex items-center">
                                    <div class="user-avatar mr-3" style="background-color: {{ $loan->client->avatar_color }}">
                                        {{ strtoupper(substr($loan->client->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-sm">{{ $loan->client->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $loan->client->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="font-semibold text-sm">KSh {{ number_format($loan->amount, 2) }}</div>
                                <div class="text-xs text-gray-500">{{ $loan->term_months }} months</div>
                            </td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs rounded-full font-medium 
                                    @if($loan->status == 'approved') bg-green-100 text-green-800
                                    @elseif($loan->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($loan->status == 'rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="text-sm text-gray-600">{{ $loan->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $loan->created_at->format('H:i') }}</div>
                            </td>
                            <td class="py-3 text-right">
                                <button class="text-blue-600 hover:text-blue-800 mr-2">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-green-600 hover:text-green-800 mr-2">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Recent Clients -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Recent Clients</h2>
                <a href="{{ route('admin.clients.index') }}" class="text-blue-600 text-sm hover:text-blue-800">View All</a>
            </div>
            
            <div class="space-y-4">
                @foreach($recent_clients as $client)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="user-avatar mr-3" style="background-color: {{ $client->avatar_color }}">
                            {{ strtoupper(substr($client->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-medium text-sm">{{ $client->name }}</div>
                            <div class="text-xs text-gray-500">{{ $client->email }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-semibold">KSh {{ number_format($client->savings_balance, 2) }}</div>
                        <div class="text-xs text-gray-500">Joined {{ $client->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Loan Trends Chart
    const loanTrendsCtx = document.getElementById('loanTrendsChart');
    if (loanTrendsCtx) {
        const gradient = loanTrendsCtx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');
        
        new Chart(loanTrendsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Loan Applications',
                    data: [120, 150, 180, 200, 220, 250, 280, 300, 280, 320, 350, 400],
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: gradient,
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { 
                            color: '#6b7280',
                            font: { size: 12 }
                        },
                        grid: { 
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: { 
                            color: '#6b7280',
                            font: { size: 12 }
                        },
                        grid: { 
                            display: false,
                            drawBorder: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }
                }
            }
        });
    }
    
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue',
                    data: [120000, 150000, 180000, 200000, 220000, 250000],
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { 
                            color: '#6b7280',
                            font: { size: 10 }
                        },
                        grid: { 
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: { 
                            color: '#6b7280',
                            font: { size: 10 }
                        },
                        grid: { 
                            display: false,
                            drawBorder: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
    
    // Expense Chart
    const expenseCtx = document.getElementById('expenseChart');
    if (expenseCtx) {
        new Chart(expenseCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Expenses',
                    data: [45000, 50000, 48000, 52000, 55000, 58000],
                    backgroundColor: 'rgba(147, 51, 234, 0.8)',
                    borderColor: 'rgba(147, 51, 234, 1)',
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { 
                            color: '#6b7280',
                            font: { size: 10 }
                        },
                        grid: { 
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: { 
                            color: '#6b7280',
                            font: { size: 10 }
                        },
                        grid: { 
                            display: false,
                            drawBorder: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
    
    // Real-time updates simulation
    function simulateRealTimeUpdates() {
        const activityFeed = document.querySelector('.real-time-updates');
        if (activityFeed) {
            // This would be replaced with actual WebSocket connection in production
            setInterval(() => {
                // Simulate new activity
                const timestamp = new Date().toLocaleTimeString();
                console.log(`[${timestamp}] Checking for new activity...`);
            }, 30000); // Check every 30 seconds
        }
    }
    
    // Initialize real-time updates
    simulateRealTimeUpdates();
    
    // Add hover effects to cards
    const cards = document.querySelectorAll('.card-hover');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endsection
