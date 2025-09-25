<?php
namespace Database\Factories;
use App\Models\Savings;
use Illuminate\Database\Eloquent\Factories\Factory;

class SavingsFactory extends Factory {
    protected $model = Savings::class;

    public function definition(): array {
        return [
            'client_id' => \App\Models\Client::factory(),
            'balance' => fake()->randomFloat(2, 0, 10000),
        ];
    }
}
