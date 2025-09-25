<?php
namespace App\Console;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {
    protected $commands = [
        // Register custom commands here
    ];

    protected function schedule(Schedule $schedule): void {
        // Example: Send reminders for due loans
        $schedule->command('loans:remind')->daily();
    }

    protected function commands(): void {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
