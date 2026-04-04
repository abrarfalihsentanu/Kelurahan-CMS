<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'subject' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['complaint', 'suggestion', 'question']),
            'message' => $this->faker->paragraph(),
            'is_read' => false,
            'status' => $this->faker->randomElement(['open', 'in_progress', 'resolved']),
            'response' => null,
            'responded_at' => null,
            'responded_by' => null,
        ];
    }
}
