<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Loan;
use App\Models\Savings;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'client']);

        $client = User::create([
            'name' => 'Test Client',
            'email' => 'client@wealthbuild.com',
            'password' => bcrypt('password'),
            'role' => 'client',
            'phone' => '+254722222222',
            'savings_balance' => 5000,
            'loan_limit' => 75000,
            'credit_score' => 50,
        ]);
        $client->assignRole('client');

        Savings::create(['client_id' => $client->id, 'balance' => 5000]);

        Loan::create([
            'client_id' => $client->id,
            'amount' => 10000,
            'term_months' => 12,
            'interest_rate' => 12,
            'limit_boost' => 2500,
            'status' => 'pending',
        ]);

        $client2 = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@wealthbuild.com',
            'password' => bcrypt('password'),
            'role' => 'client',
            'phone' => '+254733333333',
            'savings_balance' => 10000,
            'loan_limit' => 100000,
            'credit_score' => 65,
        ]);
        $client2->assignRole('client');

        Savings::create(['client_id' => $client2->id, 'balance' => 10000]);

        Loan::create([
            'client_id' => $client2->id,
            'amount' => 25000,
            'term_months' => 6,
            'interest_rate' => 12,
            'limit_boost' => 5000,
            'status' => 'approved',
        ]);
    }
}
