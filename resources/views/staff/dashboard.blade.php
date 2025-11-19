@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-600">Pending Loans</h3>
                <p class="text-2xl font-bold">{{ $pendingLoans }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-600">Approved Loans</h3>
                <p class="text-2xl font-bold">{{ $approvedLoans }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-chart-line text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-600">Total Processed</h3>
                <p class="text-2xl font-bold">{{ $pendingLoans + $approvedLoans }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Loan Management</h2>
    <p class="text-gray-600">Welcome to the Staff Dashboard. Use this panel to manage loan applications and client requests.</p>
    
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="border-l-4 border-blue-500 bg-blue-50 p-4">
            <h3 class="font-semibold text-blue-800">Pending Review</h3>
            <p class="text-blue-600">{{ $pendingLoans }} loans awaiting your approval</p>
        </div>
        
        <div class="border-l-4 border-green-500 bg-green-50 p-4">
            <h3 class="font-semibold text-green-800">Approved Loans</h3>
            <p class="text-green-600">{{ $approvedLoans }} loans successfully processed</p>
        </div>
    </div>
</div>
@endsection
