<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_name' => fake()->randomElement(['General Management', 'Marketing', 'Operations', 'Finance', 'Human Resource', 'Purchase', 'Information Technology', 'Production']),
            'department_details' => fake()->paragraphs(3, true),
        ];
    }
}
