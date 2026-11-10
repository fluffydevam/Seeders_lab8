<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class StudentController extends Controller
{
    /**
     * Show the form for creating a new student.
     */
    public function create(): View
    {
        return view('students.create', ['student' => new Student]);
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(StudentRequest $request): RedirectResponse
    {
        $student = Student::create($request->validated());

        return redirect()
            ->route('dashboard')
            ->with('status', "{$student->name} was added to the student list.");
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student): View
    {
        return view('students.edit', ['student' => $student]);
    }

    /**
     * Update the specified student in storage.
     */
    public function update(StudentRequest $request, Student $student): RedirectResponse
    {
        $student->update($request->validated());

        return redirect()
            ->route('dashboard')
            ->with('status', "{$student->name}'s details were updated.");
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $name = $student->name;

        $student->delete();

        return redirect()
            ->route('dashboard')
            ->with('status', "{$name} was removed from the student list.");
    }
}
