@props(['column', 'sort', 'direction'])

@if ($sort === $column)
    <svg @class(['h-3 w-3', 'rotate-180' => $direction === 'desc']) viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 0 1-1.06-.02L10 8.832 6.29 12.77a.75.75 0 1 1-1.08-1.04l4.25-4.5a.75.75 0 0 1 1.08 0l4.25 4.5a.75.75 0 0 1-.02 1.06Z" clip-rule="evenodd" />
    </svg>
@else
    <svg class="h-3 w-3 opacity-40" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M10 3.5a.75.75 0 0 1 .53.22l3.25 3.25a.75.75 0 1 1-1.06 1.06L10 5.56 7.28 8.28a.75.75 0 0 1-1.06-1.06l3.25-3.25A.75.75 0 0 1 10 3.5Zm-3.78 9.44a.75.75 0 0 1 1.06 0L10 15.66l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0l-3.25-3.25a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
    </svg>
@endif
