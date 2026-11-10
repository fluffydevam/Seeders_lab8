<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * The total number of students the seeder aims to keep in the database.
     */
    private const TARGET_STUDENT_COUNT = 12;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::firstOrCreate(
            ['email' => 'juan@example.com'],
            ['name' => 'Juan Dela Cruz', 'age' => 20],
        );

        Student::firstOrCreate(
            ['email' => 'maria@example.com'],
            ['name' => 'Maria Santos', 'age' => 22],
        );

        $remaining = max(0, self::TARGET_STUDENT_COUNT - Student::count());

        if ($remaining > 0) {
            Student::factory($remaining)->create();
        }
    }
}
