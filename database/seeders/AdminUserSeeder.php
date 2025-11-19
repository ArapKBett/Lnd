<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@loanease.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '+254700000000',
            'credit_score' => 100,
            'loan_limit' => 1000000,
        ]);

        User::create([
            'name' => 'Loan Officer',
            'email' => 'staff@loanease.com', 
            'password' => Hash::make('staff123'),
            'role' => 'staff',
            'phone' => '+254711111111',
        ]);

        User::create([
            'name' => 'Test Client',
            'email' => 'client@loanease.com',
            'password' => Hash::make('client123'),
            'role' => 'client',
            'phone' => '+254722222222',
        ]);

        echo "Default users created:\n";
        echo "Admin: admin@loanease.com / admin123\n";
        echo "Staff: staff@loanease.com / staff123\n";
        echo "Client: client@loanease.com / client123\n";
    }
}
