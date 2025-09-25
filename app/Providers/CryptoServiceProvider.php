<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class CryptoServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->app->singleton('crypto', function () {
            return Http::withHeaders(['API-KEY' => env('COINREMITTER_API_KEY')])
                ->baseUrl('https://coinremitter.com/api/v3');
        });
    }

    public function boot(): void {
        //
    }
}
