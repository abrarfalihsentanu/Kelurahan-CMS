<?php

namespace Database\Factories;

use App\Models\ComplaintCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Complaint>
 */
class ComplaintFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'complaint_category_id' => ComplaintCategory::factory(),
            'name' => $this->faker->name(),
            'nik' => $this->faker->numerify('##############'),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'address' => $this->faker->address(),
            'rt_rw' => $this->faker->numerify('##/##'),
            'subject' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->address(),
            'incident_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'resolved', 'closed']),
            'is_read' => false,
            'response' => null,
            'responded_at' => null,
            'responded_by' => null,
        ];
    }

    /**
     * Indicate that the complaint has been responded to.
     */
    public function responded(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'resolved',
            'response' => $this->faker->paragraph(),
            'responded_at' => now(),
            'responded_by' => 1,
            'is_read' => true,
        ]);
    }
}
