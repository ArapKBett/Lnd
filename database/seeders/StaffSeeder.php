<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'staff']);

        $staff = User::create([
            'name' => 'Loan Officer',
            'email' => 'staff@wealthbuild.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
            'phone' => '+254711111111',
        ]);
        $staff->assignRole('staff');

        $staff2 = User::create([
            'name' => 'Senior Loan Officer',
            'email' => 'staff2@wealthbuild.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
            'phone' => '+254711111112',
        ]);
        $staff2->assignRole('staff');
    }
}
