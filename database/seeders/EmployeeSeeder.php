<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Tag;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::factory(25)->create();

        Employee::factory(200)->create()->each(function ($employee) use($tags) {
            $employee->tags()->attach($tags->random(3));
        });
    }
}
