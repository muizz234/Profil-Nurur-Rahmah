@props([
    'action',
    'label' => 'Hapus',
    'message' => 'Yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.',
])

<div
    x-data="{
        open: false,
        close() {
            this.open = false;
            this.$nextTick(() => this.$refs.trigger?.focus());
        },
    }"
    @keydown.escape.window="if (open) close()"
    class="inline-flex"
>
    <button
        type="button"
        x-ref="trigger"
        @click="open = true"
        {{ $attributes->merge(['class' => 'inline-flex min-h-11 items-center justify-center gap-1.5 rounded-full border border-red-200 px-3.5 py-2.5 text-xs font-semibold text-red-600 transition hover:border-red-300 hover:bg-red-50']) }}
    >
        <svg viewBox="0 0 20 20" class="h-3.5 w-3.5" fill="none" aria-hidden="true">
            <path d="M4 6h12M8 6V4.5A1.5 1.5 0 0 1 9.5 3h1A1.5 1.5 0 0 1 12 4.5V6m2 0v9a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 6 15V6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        {{ $label }}
    </button>

    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="close()"></div>

        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="relative max-h-[85dvh] w-full max-w-sm overflow-y-auto rounded-2xl bg-white p-6 shadow-xl"
        >
            <h3 class="text-base font-bold text-slate-900">Konfirmasi Hapus</h3>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $message }}</p>

            <div class="mt-5 flex justify-end gap-2">
                <button
                    type="button"
                    @click="close()"
                    class="inline-flex min-h-11 items-center justify-center rounded-full border border-slate-200 px-5 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Batal
                </button>

                <form method="POST" action="{{ $action }}">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="inline-flex min-h-11 items-center justify-center rounded-full bg-red-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700"
                    >
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
