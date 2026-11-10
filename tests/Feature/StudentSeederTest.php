<?php

namespace Tests\Feature;

use App\Models\Student;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\StudentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_seeder_creates_twelve_students(): void
    {
        $this->seed(StudentSeeder::class);

        $this->assertDatabaseCount('students', 12);
    }

    public function test_student_seeder_creates_the_fixed_records(): void
    {
        $this->seed(StudentSeeder::class);

        $this->assertDatabaseHas('students', [
            'name' => 'Juan Dela Cruz',
            'email' => 'juan@example.com',
            'age' => 20,
        ]);

        $this->assertDatabaseHas('students', [
            'name' => 'Maria Santos',
            'email' => 'maria@example.com',
            'age' => 22,
        ]);
    }

    public function test_student_seeder_generates_unique_emails_and_valid_ages(): void
    {
        $this->seed(StudentSeeder::class);

        $students = Student::all();

        $this->assertCount(12, $students->pluck('email')->unique());

        $factoryStudents = $students->whereNotIn('email', ['juan@example.com', 'maria@example.com']);

        $this->assertCount(10, $factoryStudents);
        $this->assertTrue(
            $factoryStudents->every(fn (Student $student) => $student->age >= 18 && $student->age <= 25),
        );
    }

    public function test_student_seeder_can_be_run_multiple_times(): void
    {
        $this->seed(StudentSeeder::class);
        $this->seed(StudentSeeder::class);

        $this->assertDatabaseCount('students', 12);
    }

    public function test_database_seeder_creates_a_user_and_students(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        $this->assertDatabaseCount('students', 12);
    }

    public function test_database_seeder_can_be_run_multiple_times(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('students', 12);
    }
}
