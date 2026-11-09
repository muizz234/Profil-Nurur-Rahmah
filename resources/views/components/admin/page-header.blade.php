@props([
    'title',
    'description' => null,
    'eyebrow' => null,
])

<div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div class="min-w-0">
        @if ($eyebrow)
            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-700">{{ $eyebrow }}</p>
        @endif

        <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>

        @if ($description)
            <p class="mt-1 max-w-2xl text-sm leading-relaxed text-slate-500">{{ $description }}</p>
        @endif
    </div>

    @isset($actions)
        <div class="flex w-full min-w-0 flex-col gap-2 sm:w-auto sm:shrink-0 sm:flex-row sm:flex-wrap sm:items-center sm:justify-end">
            {{ $actions }}
        </div>
    @endisset
</div>
