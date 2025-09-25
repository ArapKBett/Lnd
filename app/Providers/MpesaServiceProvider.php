<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Iankumu\Mpesa\Mpesa;

class MpesaServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->app->singleton('mpesa', function () {
            return new Mpesa();
        });
    }

    public function boot(): void {
        //
    }
}
