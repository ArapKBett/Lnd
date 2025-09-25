<?php
namespace Database\Seeders;
use App\Models\User;
use App\Models\Loan;
use App\Models\Savings;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ClientSeeder extends Seeder {
    public function run(): void {
        Role::create(['name' => 'client']);
        // Default client
        $client = User::create([
            'name' => 'Test Client',
            'email' => 'client@wealthbuild.com',
            'password' => bcrypt('password'),
            'role' => 'client',
        ]);
        $client->assignRole('client');
        Savings::create(['client_id' => $client->id, 'balance' => 5000]);
        Loan::create([
            'client_id' => $client->id,
            'amount' => 10000,
            'term_months' => 12,
            'interest_rate' => 10,
            'limit_boost' => 2500, // 50% of savings
            'status' => 'pending',
        ]);

        // Additional clients
        User::factory()->count(5)->create(['role' => 'client'])->each(function ($user) {
            $user->assignRole('client');
            Savings::factory()->create(['client_id' => $user->id]);
            Loan::factory()->count(2)->create(['client_id' => $user->id]);
        });
    }
}