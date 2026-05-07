@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Add New Staff Member</h2>

        <form action="{{ route('admin.staff.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-purple-500" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-purple-500" required>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full p-2 border rounded focus:ring-2 focus:ring-purple-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-2 border rounded focus:ring-2 focus:ring-purple-500" required>
                </div>

                <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded font-semibold hover:bg-purple-700">
                    Create Staff Member
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
