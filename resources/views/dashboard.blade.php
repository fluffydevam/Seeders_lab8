@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
    @php
        $sortLink = function (string $column) use ($sort, $direction, $search): string {
            $nextDirection = $sort === $column && $direction === 'asc' ? 'desc' : 'asc';

            return route('dashboard', array_filter([
                'q' => $search !== '' ? $search : null,
                'sort' => $column,
                'direction' => $nextDirection,
            ]));
        };

        $cards = [
            ['label' => 'Total students', 'value' => $stats['total'], 'hint' => 'All records'],
            ['label' => 'Average age', 'value' => $stats['averageAge'] !== null ? number_format($stats['averageAge'], 1) : '—', 'hint' => 'Across all students'],
            ['label' => 'Youngest', 'value' => $stats['youngest'] ?? '—', 'hint' => 'Lowest age'],
            ['label' => 'Oldest', 'value' => $stats['oldest'] ?? '—', 'hint' => 'Highest age'],
            ['label' => 'Added this week', 'value' => $stats['addedThisWeek'], 'hint' => 'Last 7 days'],
        ];
    @endphp

    <div class="space-y-8">
        <div>
            <h1 class="text-4xl font-bold tracking-tight text-ink">Overview</h1>
            <p class="mt-2 text-base text-graphite">A quick look at the students stored in the database.</p>
        </div>

        <div class="grid grid-cols-2 gap-4 lg:grid-cols-3 xl:grid-cols-5">
            @foreach ($cards as $card)
                <div class="border border-line bg-surface p-4">
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 shrink-0 bg-link" aria-hidden="true"></span>
                        <p class="text-xs font-medium uppercase tracking-[0.08em] text-graphite">{{ $card['label'] }}</p>
                    </div>
                    <p class="mt-3 font-mono text-2xl font-bold tabular-nums text-ink">{{ $card['value'] }}</p>
                    <p class="mt-1 text-xs text-graphite">{{ $card['hint'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="border border-line bg-surface">
            <div class="flex flex-col gap-4 border-b border-line p-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-ink">Students</h2>
                    <p class="mt-1 text-sm text-graphite">
                        {{ $students->total() }} {{ \Illuminate\Support\Str::plural('student', $students->total()) }} found
                        @if ($search !== '')
                            for &ldquo;{{ $search }}&rdquo;
                        @endif
                    </p>
                </div>

                <form method="GET" action="{{ route('dashboard') }}" class="flex w-full gap-2 sm:w-auto">
                    @if ($sort !== 'created_at' || $direction !== 'desc')
                        <input type="hidden" name="sort" value="{{ $sort }}">
                        <input type="hidden" name="direction" value="{{ $direction }}">
                    @endif

                    <label for="q" class="sr-only">Search students</label>
                    <input id="q" name="q" type="search" value="{{ $search }}" placeholder="Search name or email…"
                           class="w-full rounded-[2px] border border-line bg-surface px-3 py-2 text-sm text-ink placeholder:text-graphite/60 focus:border-link focus:outline-none focus:ring-2 focus:ring-link/30 focus:ring-offset-2 focus:ring-offset-surface sm:w-64">

                    <button type="submit"
                            class="inline-flex items-center rounded-[2px] border-[1.5px] border-graphite/40 bg-transparent px-4 py-2 text-sm font-semibold text-ink transition-colors duration-150 hover:bg-ink/5 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-solid focus-visible:outline-link">
                        Search
                    </button>

                    @if ($search !== '')
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-link transition-colors duration-150 hover:text-link/75">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-line text-left text-sm">
                    <thead class="bg-canvas text-xs uppercase tracking-[0.08em] text-graphite">
                        <tr>
                            <th scope="col" class="px-4 py-3 font-medium sm:px-6">#</th>
                            <th scope="col" aria-sort="{{ $sort === 'name' ? ($direction === 'asc' ? 'ascending' : 'descending') : 'none' }}" class="px-4 py-3 font-medium sm:px-6">
                                <a href="{{ $sortLink('name') }}" @class(['inline-flex items-center gap-1.5 transition-colors duration-150', 'text-link' => $sort === 'name', 'hover:text-ink' => $sort !== 'name'])>
                                    Name <x-sort-icon column="name" :sort="$sort" :direction="$direction" />
                                </a>
                            </th>
                            <th scope="col" aria-sort="{{ $sort === 'email' ? ($direction === 'asc' ? 'ascending' : 'descending') : 'none' }}" class="px-4 py-3 font-medium sm:px-6">
                                <a href="{{ $sortLink('email') }}" @class(['inline-flex items-center gap-1.5 transition-colors duration-150', 'text-link' => $sort === 'email', 'hover:text-ink' => $sort !== 'email'])>
                                    Email <x-sort-icon column="email" :sort="$sort" :direction="$direction" />
                                </a>
                            </th>
                            <th scope="col" aria-sort="{{ $sort === 'age' ? ($direction === 'asc' ? 'ascending' : 'descending') : 'none' }}" class="px-4 py-3 font-medium sm:px-6">
                                <a href="{{ $sortLink('age') }}" @class(['inline-flex items-center gap-1.5 transition-colors duration-150', 'text-link' => $sort === 'age', 'hover:text-ink' => $sort !== 'age'])>
                                    Age <x-sort-icon column="age" :sort="$sort" :direction="$direction" />
                                </a>
                            </th>
                            <th scope="col" aria-sort="{{ $sort === 'created_at' ? ($direction === 'asc' ? 'ascending' : 'descending') : 'none' }}" class="px-4 py-3 font-medium sm:px-6">
                                <a href="{{ $sortLink('created_at') }}" @class(['inline-flex items-center gap-1.5 transition-colors duration-150', 'text-link' => $sort === 'created_at', 'hover:text-ink' => $sort !== 'created_at'])>
                                    Added <x-sort-icon column="created_at" :sort="$sort" :direction="$direction" />
                                </a>
                            </th>
                            <th scope="col" class="px-4 py-3 text-right font-medium sm:px-6">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-line bg-surface">
                        @forelse ($students as $student)
                            <tr class="transition-colors duration-150 hover:bg-canvas">
                                <td class="whitespace-nowrap px-4 py-4 font-mono text-xs text-graphite sm:px-6">
                                    {{ $students->firstItem() + $loop->index }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 sm:px-6">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[2px] bg-link/10 font-mono text-sm font-semibold text-link">
                                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($student->name, 0, 1)) }}
                                        </span>
                                        <span class="font-medium text-ink">{{ $student->name }}</span>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 text-graphite sm:px-6">{{ $student->email }}</td>
                                <td class="whitespace-nowrap px-4 py-4 font-mono tabular-nums text-ink sm:px-6">{{ $student->age }}</td>
                                <td class="whitespace-nowrap px-4 py-4 font-mono text-xs text-graphite sm:px-6">{{ $student->created_at->format('M j, Y') }}</td>
                                <td class="whitespace-nowrap px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('students.edit', $student) }}"
                                           class="inline-flex items-center rounded-[2px] border-[1.5px] border-graphite/40 px-3 py-1.5 text-xs font-semibold text-ink transition-colors duration-150 hover:bg-ink/5 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-solid focus-visible:outline-link">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('students.destroy', $student) }}"
                                              onsubmit="return confirm('Delete this student? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center rounded-[2px] border-[1.5px] border-danger/40 px-3 py-1.5 text-xs font-semibold text-danger transition-colors duration-150 hover:bg-danger/5 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-solid focus-visible:outline-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-[2px] bg-link/10 text-link">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                        </svg>
                                    </div>
                                    <h3 class="mt-4 text-base font-bold text-ink">No students found</h3>
                                    <p class="mt-2 text-sm text-graphite">
                                        @if ($search !== '')
                                            Nothing matches &ldquo;{{ $search }}&rdquo;. Try a different name or email.
                                        @else
                                            Get started by adding your first student record.
                                        @endif
                                    </p>
                                    <div class="mt-6 flex items-center justify-center gap-3">
                                        @if ($search !== '')
                                            <a href="{{ route('dashboard') }}"
                                               class="rounded-[2px] border-[1.5px] border-graphite/40 px-4 py-2 text-sm font-semibold text-ink transition-colors duration-150 hover:bg-ink/5">
                                                Clear search
                                            </a>
                                        @endif
                                        <a href="{{ route('students.create') }}"
                                           class="rounded-none bg-brand px-4 py-2 text-sm font-semibold text-white transition-colors duration-150 hover:bg-brand-strong active:translate-y-px">
                                            Add a student
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($students->hasPages())
                <div class="border-t border-line px-4 py-4 sm:px-6">
                    {{ $students->links('vendor.pagination.flat') }}
                </div>
            @endif
        </div>
    </div>
@endsection
