@php($kegiatan = $kegiatan ?? null)

<div class="space-y-5">
    <div>
        <label for="title" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Nama Kegiatan</label>
        <input id="title" name="title" type="text" value="{{ old('title', $kegiatan?->title) }}" class="field-input mt-2" required>
    </div>

    <div>
        <label for="category" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Kategori</label>
        <select id="category" name="category" class="field-input mt-2" required>
            <option value="">Pilih kategori</option>
            @foreach ($categories as $value => $label)
                <option value="{{ $value }}" @selected(old('category', $kegiatan?->category) === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="description" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Deskripsi</label>
        <textarea id="description" name="description" rows="5" class="field-input mt-2" required>{{ old('description', $kegiatan?->description) }}</textarea>
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <span class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Gambar Kegiatan</span>

            @if ($kegiatan?->icon_or_image)
                <div class="mt-2 overflow-hidden rounded-2xl border border-slate-100 bg-slate-50">
                    <x-landing.smart-image
                        src="{{ $kegiatan->icon_or_image }}"
                        alt="{{ $kegiatan->title }}"
                        label="{{ $kegiatan->title }}"
                        class="aspect-[16/9] w-full"
                    />
                </div>
            @endif

            <input id="icon_or_image" name="icon_or_image" type="file" accept="image/jpeg,image/png,image/webp" class="mt-3 block w-full text-xs text-slate-600 file:mr-3 file:rounded-full file:border-0 file:bg-emerald-700 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-white hover:file:bg-emerald-800">
            <p class="mt-1.5 text-xs text-slate-500">JPG, PNG, atau WEBP. Maksimal 2 MB.</p>
        </div>

        <div class="flex items-start">
            <label class="flex w-full cursor-pointer items-start gap-3 rounded-2xl border border-slate-100 bg-slate-50/60 p-4">
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    class="mt-0.5 h-4 w-4 rounded border-slate-300 text-emerald-700 focus:ring-emerald-600"
                    @checked(old('is_active', $kegiatan?->is_active ?? true))
                >
                <span>
                    <span class="block text-sm font-semibold text-slate-800">Tampilkan di beranda</span>
                    <span class="mt-0.5 block text-xs text-slate-500">Kegiatan aktif akan muncul pada bagian "Kegiatan &amp; Program".</span>
                </span>
            </label>
        </div>
    </div>
</div>
