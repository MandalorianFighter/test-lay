<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        return [
            'employee_name' => fake()->name(),
            'photo' => $faker->imageUrl(),
            'thumbnail' => $faker->imageUrl(),
            'age' => fake()->numberBetween(22, 55),
            'position' => fake()->jobTitle(),
            'department_id' => fake()->numberBetween(1, 15),
            'employee_details' => fake()->paragraphs(3, true),
        ];
    }
}
