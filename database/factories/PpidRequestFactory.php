<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PpidRequest>
 */
class PpidRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['permohonan', 'keberatan']),
            'name' => $this->faker->name(),
            'nik' => $this->faker->numerify('##############'),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'address' => $this->faker->address(),
            'occupation' => $this->faker->jobTitle(),
            'information_type' => $this->faker->word(),
            'information_detail' => $this->faker->paragraph(),
            'purpose' => $this->faker->sentence(),
            'method' => $this->faker->randomElement(['pickup', 'email', 'mail']),
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed', 'rejected']),
            'is_read' => false,
            'response' => null,
            'response_file' => null,
            'responded_at' => null,
            'responded_by' => null,
        ];
    }

    /**
     * Indicate that the request has been completed.
     */
    public function completed(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'completed',
            'response' => $this->faker->paragraph(),
            'responded_at' => now(),
            'responded_by' => 1,
            'is_read' => true,
        ]);
    }
}
