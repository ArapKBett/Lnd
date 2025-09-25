<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider {
    public function register(): void {
        //
    }

    public function boot(): void {
        // Ensure roles exist
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
            Role::create(['name' => 'staff']);
            Role::create(['name' => 'client']);
        }
    }
}
