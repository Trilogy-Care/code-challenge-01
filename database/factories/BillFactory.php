<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class BillFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bill_reference' => fake()->name(),
            'bill_date' => fake()->date(),
            'submitted_at' => fake()->date(),
            'approved_at' => fake()->date(),
            'on_hold_at' => fake()->date(),
            'bill_stage_id' => rand(0, 7),
        ];
    }
}
