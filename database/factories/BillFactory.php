<?php

namespace Database\Factories;

use App\Models\Bill;
use App\Models\BillStage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    public function submitted(): static
    {
        return $this->state(fn (array $attributes) => [
            'approved_at' => null,
            'on_hold_at' => null,
            'bill_stage_id' => BillStage::byLabel(BillStage::SUBMITTED)->firstOrFail()->id,
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'on_hold_at' => null,
            'bill_stage_id' => BillStage::byLabel(BillStage::APPROVED)->firstOrFail()->id,
        ]);
    }

    public function onHold(): static
    {
        return $this->state(fn (array $attributes) => [
            'bill_stage_id' => BillStage::byLabel(BillStage::ON_HOLD)->firstOrFail()->id,
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'bill_stage_id' => BillStage::byLabel(BillStage::REJECTED)->firstOrFail()->id,
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'bill_stage_id' => BillStage::byLabel(BillStage::PAID)->firstOrFail()->id,
        ]);
    }

    public function assignedToUser(User $user = null): static
    {
        return $this->afterCreating(function (Bill $bill) use ($user) {
            $bill->users()->attach($user ?? User::factory()->create());
        });
    }
}
