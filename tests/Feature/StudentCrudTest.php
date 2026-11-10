<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_form_is_displayed(): void
    {
        $this->get(route('students.create'))
            ->assertOk()
            ->assertSee('Add a student');
    }

    public function test_student_can_be_created(): void
    {
        $response = $this->post(route('students.store'), [
            'name' => 'New Student',
            'email' => 'new@example.com',
            'age' => 21,
        ]);

        $response->assertRedirect(route('dashboard'))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('students', [
            'name' => 'New Student',
            'email' => 'new@example.com',
            'age' => 21,
        ]);
    }

    public function test_student_creation_validates_input(): void
    {
        $response = $this->from(route('students.create'))->post(route('students.store'), [
            'name' => '',
            'email' => 'not-an-email',
            'age' => 17,
        ]);

        $response->assertRedirect(route('students.create'))
            ->assertSessionHasErrors(['name', 'email', 'age']);

        $this->assertDatabaseCount('students', 0);
    }

    public function test_email_must_be_unique(): void
    {
        Student::factory()->create(['email' => 'taken@example.com']);

        $this->from(route('students.create'))
            ->post(route('students.store'), [
                'name' => 'Another Student',
                'email' => 'taken@example.com',
                'age' => 22,
            ])
            ->assertSessionHasErrors('email');
    }

    public function test_age_must_be_between_18_and_100(): void
    {
        $this->post(route('students.store'), [
            'name' => 'Too Old',
            'email' => 'old@example.com',
            'age' => 101,
        ])->assertSessionHasErrors('age');
    }

    public function test_edit_form_is_displayed(): void
    {
        $student = Student::factory()->create();

        $this->get(route('students.edit', $student))
            ->assertOk()
            ->assertSee($student->name);
    }

    public function test_student_can_be_updated_keeping_the_same_email(): void
    {
        $student = Student::factory()->create([
            'name' => 'Old Name',
            'email' => 'same@example.com',
            'age' => 20,
        ]);

        $response = $this->put(route('students.update', $student), [
            'name' => 'Updated Name',
            'email' => 'same@example.com',
            'age' => 24,
        ]);

        $response->assertRedirect(route('dashboard'))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Updated Name',
            'email' => 'same@example.com',
            'age' => 24,
        ]);
    }

    public function test_student_can_be_deleted(): void
    {
        $student = Student::factory()->create();

        $this->delete(route('students.destroy', $student))
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('status');

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_editing_a_missing_student_returns_not_found(): void
    {
        $this->get('/students/999/edit')->assertNotFound();
    }
}
