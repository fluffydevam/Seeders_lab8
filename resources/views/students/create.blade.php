@extends('layouts.app')

@section('title', 'Add Student')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-link transition-colors duration-150 hover:text-link/75">&larr; Back to dashboard</a>
            <h1 class="mt-2 text-4xl font-bold tracking-tight text-ink">Add a student</h1>
            <p class="mt-2 text-base text-graphite">Fill in the details below to create a new student record.</p>
        </div>

        <form method="POST" action="{{ route('students.store') }}"
              class="border border-line bg-surface p-6 sm:p-8">
            @include('students._form', ['submitLabel' => 'Create student'])
        </form>
    </div>
@endsection
