@php($berita = $berita ?? null)

<div class="space-y-5">
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="title" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Judul Berita</label>
            <input id="title" name="title" type="text" value="{{ old('title', $berita?->title) }}" class="field-input mt-2" required>
        </div>

        <div>
            <label for="category_id" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Kategori</label>
            <select id="category_id" name="category_id" class="field-input mt-2" required>
                <option value="">Pilih kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((int) old('category_id', $berita?->category_id) === $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div x-data="{ content: @js(old('content', $berita?->content ?? '')) }">
        <div class="grid gap-5 lg:grid-cols-2">
            <div>
                <label for="content" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Isi Berita</label>
                <textarea id="content" name="content" x-model="content" rows="14" class="field-input mt-2" required></textarea>
                <p class="mt-2 text-xs text-slate-500">Gunakan baris kosong untuk memisahkan paragraf.</p>
            </div>

            <div>
                <span class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Pratinjau</span>
                <div class="mt-2 min-h-[14rem] rounded-xl border border-slate-100 bg-slate-50/70 p-4">
                    <div class="whitespace-pre-line text-sm leading-relaxed text-slate-700" x-text="content || 'Pratinjau isi berita akan muncul di sini.'"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <span class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Gambar Utama</span>

            @if ($berita?->image)
                <div class="mt-2 overflow-hidden rounded-2xl border border-slate-100 bg-slate-50">
                    <x-landing.smart-image
                        src="{{ $berita->image }}"
                        alt="{{ $berita->title }}"
                        label="{{ $berita->title }}"
                        class="aspect-[16/9] w-full"
                    />
                </div>
            @endif

            <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="mt-3 block w-full text-xs text-slate-600 file:mr-3 file:rounded-full file:border-0 file:bg-emerald-700 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-white hover:file:bg-emerald-800">
            <p class="mt-1.5 text-xs text-slate-500">JPG, PNG, atau WEBP. Maksimal 2 MB.</p>
        </div>

        <div class="space-y-4">
            <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-slate-100 bg-slate-50/60 p-4">
                <input
                    type="checkbox"
                    name="is_published"
                    value="1"
                    class="mt-0.5 h-4 w-4 rounded border-slate-300 text-emerald-700 focus:ring-emerald-600"
                    @checked(old('is_published', $berita?->is_published ?? true))
                >
                <span>
                    <span class="block text-sm font-semibold text-slate-800">Terbitkan berita</span>
                    <span class="mt-0.5 block text-xs text-slate-500">Berita terbit akan tampil di halaman publik.</span>
                </span>
            </label>

            <div>
                <label for="published_at" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Tanggal Terbit</label>
                <input
                    id="published_at"
                    name="published_at"
                    type="datetime-local"
                    value="{{ old('published_at', $berita?->published_at?->format('Y-m-d\TH:i')) }}"
                    class="field-input mt-2"
                >
                <p class="mt-1.5 text-xs text-slate-500">Kosongkan untuk menggunakan waktu saat ini.</p>
            </div>
        </div>
    </div>
</div>
