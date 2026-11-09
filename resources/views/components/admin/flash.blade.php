@if (session('success'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        class="mb-6 flex items-start justify-between gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900"
        role="status"
    >
        <div class="flex items-start gap-2">
            <svg viewBox="0 0 20 20" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600" fill="none" aria-hidden="true">
                <path d="m4 10.5 4 4 8-9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>

        <button type="button" @click="show = false" class="-m-1 inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-lg text-emerald-700 transition hover:bg-emerald-100 hover:text-emerald-900" aria-label="Tutup notifikasi">
            <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                <path d="m5 5 10 10M15 5 5 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </button>
    </div>
@endif

@if (session('error'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        class="mb-6 flex items-start justify-between gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900"
        role="alert"
    >
        <div class="flex items-start gap-2">
            <svg viewBox="0 0 20 20" class="mt-0.5 h-4 w-4 shrink-0 text-red-600" fill="none" aria-hidden="true">
                <path d="M10 6v5m0 3h.01M10 2.5 2.5 16.5h15L10 2.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>

        <button type="button" @click="show = false" class="-m-1 inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-lg text-red-700 transition hover:bg-red-100 hover:text-red-900" aria-label="Tutup notifikasi">
            <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" aria-hidden="true">
                <path d="m5 5 10 10M15 5 5 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900" role="alert">
        <p class="font-semibold">Periksa kembali isian berikut:</p>
        <ul class="mt-2 list-inside list-disc space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
