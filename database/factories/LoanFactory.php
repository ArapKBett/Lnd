<?php
// Similar
public function definition(): array {
    return [
        'client_id' => \App\Models\User::factory(),
        'amount' => fake()->numberBetween(1000, 50000),
        'term_months' => fake()->numberBetween(6, 24),
        'interest_rate' => fake()->randomFloat(2, 5, 20),
        'limit_boost' => 0,
        'status' => 'pending',
    ];
}
