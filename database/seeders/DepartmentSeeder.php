<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::truncate();

        $faker = \Faker\Factory::create();

        $data = [];

        for ($i = 1; $i <= 15; $i++) {
            $data[] = [
            'department_name' => $faker->departmentName(),
            'department_details' => $faker->paragraphs(3, true),
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ];
        }

        Department::insert($data);
    }
}
