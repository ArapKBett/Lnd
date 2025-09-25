<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder {
    public function run(): void {
        Role::create(['name' => 'admin']);
        $admin = User::create(['name' => 'Admin User', 'email' => 'admin@wealthbuild.com', 'password' => bcrypt('password'), 'role' => 'admin']);
        $admin->assignRole('admin');
    }
}
