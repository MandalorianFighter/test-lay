<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_name' => fake()->name(),
            'photo' => fake()->imageUrl(),
            'age' => fake()->numberBetween(22, 55),
            'position' => fake()->jobTitle(),
            'department_id' => fake()->numberBetween(1, 8),
            'employee_details' => fake()->paragraphs(3, true),
        ];
    }
}
