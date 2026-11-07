@props([
    'label',
    'value',
    'hint' => null,
])

<div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">{{ $label }}</p>
    <p class="mt-2 text-3xl font-bold tracking-tight text-emerald-900">{{ $value }}</p>

    @if ($hint)
        <p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>
    @endif
</div>
