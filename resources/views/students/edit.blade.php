@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-link transition-colors duration-150 hover:text-link/75">&larr; Back to dashboard</a>
            <h1 class="mt-2 text-4xl font-bold tracking-tight text-ink">Edit student</h1>
            <p class="mt-2 text-base text-graphite">Update {{ $student->name }}&rsquo;s details below.</p>
        </div>

        <form method="POST" action="{{ route('students.update', $student) }}"
              class="border border-line bg-surface p-6 sm:p-8">
            @include('students._form', ['submitLabel' => 'Save changes'])
        </form>

        <div class="mt-6 flex flex-col gap-4 border border-danger/40 bg-danger/5 p-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-danger">Danger zone</p>
                <p class="mt-1 text-sm text-graphite">Deleting this student cannot be undone.</p>
            </div>

            <form method="POST" action="{{ route('students.destroy', $student) }}"
                  onsubmit="return confirm('Delete this student? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="rounded-[2px] border-[1.5px] border-danger/40 px-4 py-2 text-sm font-semibold text-danger transition-colors duration-150 hover:bg-danger/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-solid focus-visible:outline-danger">
                    Delete student
                </button>
            </form>
        </div>
    </div>
@endsection
