<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@wealthbuild.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '+254700000000',
            'credit_score' => 100,
            'loan_limit' => 1000000,
        ]);
        $admin->assignRole('admin');
    }
}
