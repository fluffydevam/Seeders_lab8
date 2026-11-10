<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_students_and_statistics(): void
    {
        Student::factory()->create(['name' => 'Alice Smith', 'email' => 'alice@example.com', 'age' => 20]);
        Student::factory()->create(['name' => 'Bob Jones', 'email' => 'bob@example.com', 'age' => 30]);

        $response = $this->get(route('dashboard'));

        $response->assertOk()
            ->assertSee('Alice Smith')
            ->assertSee('Bob Jones')
            ->assertSee('Total students')
            ->assertSee('25.0');
    }

    public function test_dashboard_shows_an_empty_state_when_there_are_no_students(): void
    {
        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee('No students found');
    }

    public function test_dashboard_includes_the_theme_toggle(): void
    {
        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee('data-theme-toggle', false)
            ->assertSee('Toggle dark mode', false);
    }

    public function test_students_can_be_searched_by_name_or_email(): void
    {
        Student::factory()->create(['name' => 'Alice Smith', 'email' => 'alice@example.com']);
        Student::factory()->create(['name' => 'Bob Jones', 'email' => 'bob@example.com']);

        $this->get(route('dashboard', ['q' => 'alice']))
            ->assertOk()
            ->assertSee('Alice Smith')
            ->assertDontSee('Bob Jones');

        $this->get(route('dashboard', ['q' => 'bob@example.com']))
            ->assertOk()
            ->assertSee('Bob Jones')
            ->assertDontSee('Alice Smith');
    }

    public function test_students_can_be_sorted_by_name(): void
    {
        Student::factory()->create(['name' => 'Charlie Brown', 'email' => 'charlie@example.com']);
        Student::factory()->create(['name' => 'Alice Smith', 'email' => 'alice@example.com']);

        $this->get(route('dashboard', ['sort' => 'name', 'direction' => 'asc']))
            ->assertOk()
            ->assertSeeInOrder(['Alice Smith', 'Charlie Brown']);
    }

    public function test_invalid_sort_parameters_fall_back_to_defaults(): void
    {
        Student::factory()->create(['name' => 'Alice Smith', 'email' => 'alice@example.com']);

        $this->get(route('dashboard', ['sort' => 'password', 'direction' => 'sideways']))
            ->assertOk()
            ->assertSee('Alice Smith');
    }

    public function test_students_are_paginated(): void
    {
        Student::factory()->count(12)->create();

        $firstPage = $this->get(route('dashboard'))->viewData('students');
        $this->assertSame(10, $firstPage->count());
        $this->assertSame(12, $firstPage->total());

        $secondPage = $this->get(route('dashboard', ['page' => 2]))->viewData('students');
        $this->assertSame(2, $secondPage->count());
    }
}
