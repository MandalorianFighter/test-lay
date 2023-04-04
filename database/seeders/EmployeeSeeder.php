<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::truncate();

        $faker = \Faker\Factory::create();

        $data = [];

        for($i = 1; $i <= 1000; $i++) {
            $item = [
                'employee_name' => $faker->name(),
                'photo' => $faker->imageUrl(),
                'age' => $faker->numberBetween(22, 55),
                'position' => $faker->jobTitle(),
                'department_id' => $faker->numberBetween(1, 15),
                'employee_details' => $faker->paragraphs(3, true),
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ];

            $data[] = $item;
        }

        Employee::insert($data); 
    }
}
