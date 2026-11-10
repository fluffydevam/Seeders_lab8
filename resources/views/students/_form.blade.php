@csrf

@if ($student->exists)
    @method('PUT')
@endif

<div class="space-y-6">
    <div>
        <label for="name" class="block text-xs font-medium uppercase tracking-[0.08em] text-graphite">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $student->name) }}" required autofocus
               @if ($errors->has('name')) aria-invalid="true" aria-describedby="name-error" @endif
               @class([
                   'mt-2 block w-full rounded-[2px] border bg-surface px-3 py-2 text-sm text-ink placeholder:text-graphite/60 focus:border-link focus:outline-none focus:ring-2 focus:ring-link/30 focus:ring-offset-2 focus:ring-offset-surface',
                   'border-line' => ! $errors->has('name'),
                   'border-danger' => $errors->has('name'),
               ])>
        @error('name')
            <p id="name-error" class="mt-2 text-sm text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-xs font-medium uppercase tracking-[0.08em] text-graphite">Email address</label>
        <input id="email" name="email" type="email" value="{{ old('email', $student->email) }}" required
               @if ($errors->has('email')) aria-invalid="true" aria-describedby="email-error" @endif
               @class([
                   'mt-2 block w-full rounded-[2px] border bg-surface px-3 py-2 text-sm text-ink placeholder:text-graphite/60 focus:border-link focus:outline-none focus:ring-2 focus:ring-link/30 focus:ring-offset-2 focus:ring-offset-surface',
                   'border-line' => ! $errors->has('email'),
                   'border-danger' => $errors->has('email'),
               ])>
        @error('email')
            <p id="email-error" class="mt-2 text-sm text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="age" class="block text-xs font-medium uppercase tracking-[0.08em] text-graphite">Age</label>
        <input id="age" name="age" type="number" min="18" max="100" value="{{ old('age', $student->age) }}" required
               @if ($errors->has('age')) aria-invalid="true" aria-describedby="age-hint age-error" @else aria-describedby="age-hint" @endif
               @class([
                   'mt-2 block w-full rounded-[2px] border bg-surface px-3 py-2 text-sm text-ink placeholder:text-graphite/60 focus:border-link focus:outline-none focus:ring-2 focus:ring-link/30 focus:ring-offset-2 focus:ring-offset-surface sm:w-40',
                   'border-line' => ! $errors->has('age'),
                   'border-danger' => $errors->has('age'),
               ])>
        <p id="age-hint" class="mt-2 text-xs text-graphite">Must be between 18 and 100.</p>
        @error('age')
            <p id="age-error" class="mt-2 text-sm text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-end gap-3 border-t border-line pt-6">
        <a href="{{ route('dashboard') }}"
           class="rounded-[2px] border-[1.5px] border-graphite/40 px-4 py-2 text-sm font-semibold text-ink transition-colors duration-150 hover:bg-ink/5 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-solid focus-visible:outline-link">
            Cancel
        </a>
        <button type="submit"
                class="rounded-none bg-brand px-4 py-2 text-sm font-semibold text-white transition-colors duration-150 hover:bg-brand-strong active:translate-y-px focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-solid focus-visible:outline-link">
            {{ $submitLabel }}
        </button>
    </div>
</div>
