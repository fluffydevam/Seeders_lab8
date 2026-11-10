<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Student Dashboard')</title>

    <script>
        (function () {
            try {
                var stored = localStorage.getItem('theme');
                var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                document.documentElement.classList.toggle('dark', stored === null ? prefersDark : stored === 'dark');
            } catch (error) {
                // Fall back to the light theme when storage is unavailable.
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-[100dvh] flex-col bg-canvas font-sans text-ink antialiased">
    @php($dashboardActive = request()->routeIs('dashboard'))

    <header class="sticky top-0 z-[100] border-b border-line bg-surface">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-3 px-4 sm:px-6 lg:px-8">
            <div class="flex min-w-0 items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[2px] bg-brand text-white">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                    </span>
                    <span class="hidden flex-col sm:flex">
                        <span class="text-base font-bold leading-tight tracking-tight text-ink">Student Dashboard</span>
                        <span class="text-xs leading-tight text-graphite">Manage and explore student records</span>
                    </span>
                </a>

                <nav class="hidden items-center gap-6 md:flex" aria-label="Primary">
                    <a href="{{ route('dashboard') }}"
                       @if ($dashboardActive) aria-current="page" @endif
                       @class([
                           'border-b-2 py-1.5 text-sm font-medium transition-colors duration-150',
                           'border-link text-ink' => $dashboardActive,
                           'border-transparent text-graphite hover:text-ink' => ! $dashboardActive,
                       ])>
                        Dashboard
                    </a>
                </nav>
            </div>

            <div class="flex shrink-0 items-center gap-2 sm:gap-3">
                <button type="button" data-theme-toggle aria-label="Toggle dark mode" aria-pressed="false"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-[2px] border border-line bg-surface text-graphite transition-colors duration-150 hover:bg-ink/5 hover:text-ink focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-solid focus-visible:outline-link">
                    <svg class="h-4 w-4 dark:hidden" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2.25a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75ZM7.5 12a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM18.894 6.166a.75.75 0 0 0-1.06-1.06l-1.591 1.59a.75.75 0 1 0 1.06 1.061l1.591-1.59ZM21.75 12a.75.75 0 0 1-.75.75h-2.25a.75.75 0 0 1 0-1.5H21a.75.75 0 0 1 .75.75ZM17.834 18.894a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 1 0-1.061 1.06l1.59 1.591ZM12 18a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-2.25A.75.75 0 0 1 12 18ZM7.758 17.303a.75.75 0 0 0-1.061-1.06l-1.591 1.59a.75.75 0 0 0 1.06 1.061l1.591-1.59ZM6 12a.75.75 0 0 1-.75.75H3a.75.75 0 0 1 0-1.5h2.25A.75.75 0 0 1 6 12ZM6.697 7.757a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 0 0-1.061 1.06l1.59 1.591Z" />
                    </svg>
                    <svg class="hidden h-4 w-4 dark:block" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9.528 1.718a.75.75 0 0 1 .162.819A8.97 8.97 0 0 0 9 6a9 9 0 0 0 9 9 8.97 8.97 0 0 0 3.463-.69.75.75 0 0 1 .981.98 10.503 10.503 0 0 1-9.694 6.46c-5.799 0-10.5-4.7-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 0 1 .818.162Z" clip-rule="evenodd" />
                    </svg>
                </button>

                <a href="{{ route('students.create') }}"
                   class="inline-flex items-center gap-2 rounded-none bg-brand px-3 py-2 text-sm font-semibold text-white transition-colors duration-150 hover:bg-brand-strong active:translate-y-px focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-solid focus-visible:outline-link sm:px-4">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span class="hidden sm:inline">New Student</span>
                    <span class="sm:hidden">New</span>
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-6 flex items-start gap-3 border border-line border-l-4 border-l-link bg-surface px-4 py-3 text-sm text-ink" role="status">
                <svg class="mt-0.5 h-4 w-4 shrink-0 text-link" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-line bg-surface">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-1 px-4 py-4 text-xs text-graphite sm:flex-row sm:px-6 lg:px-8">
            <p>Student Dashboard</p>
            <p class="font-mono">Laravel v{{ Illuminate\Foundation\Application::VERSION }}</p>
        </div>
    </footer>
</body>
</html>
