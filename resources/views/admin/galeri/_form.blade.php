@php($galeri = $galeri ?? null)

<div class="space-y-5">
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="title" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Judul Foto</label>
            <input id="title" name="title" type="text" value="{{ old('title', $galeri?->title) }}" class="field-input mt-2" required>
        </div>

        <div>
            <label for="category_id" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Kategori</label>
            <select id="category_id" name="category_id" class="field-input mt-2">
                <option value="">Tanpa kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((int) old('category_id', $galeri?->category_id) === $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label for="caption" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Keterangan</label>
        <input id="caption" name="caption" type="text" value="{{ old('caption', $galeri?->caption) }}" class="field-input mt-2" placeholder="Deskripsi singkat foto">
    </div>

    <div>
        <span class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Foto</span>

        @if ($galeri?->image_path)
            <div class="mt-2 max-w-xs overflow-hidden rounded-2xl border border-slate-100 bg-slate-50">
                <x-landing.smart-image
                    src="{{ $galeri->image_path }}"
                    alt="{{ $galeri->title }}"
                    label="{{ $galeri->title }}"
                    class="aspect-[4/3] w-full"
                />
            </div>
        @endif

        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="mt-3 block w-full text-xs text-slate-600 file:mr-3 file:rounded-full file:border-0 file:bg-emerald-700 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-white hover:file:bg-emerald-800" @if (! $galeri) required @endif>
        <p class="mt-1.5 text-xs text-slate-500">JPG, PNG, atau WEBP. Maksimal 2 MB.{{ $galeri ? ' Kosongkan jika tidak ingin mengganti foto.' : '' }}</p>
    </div>
</div>
