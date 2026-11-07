@extends('layouts.admin')

@section('title', 'Profil Pesantren — Admin Nurur Rahmah')

@section('content')
    <x-admin.page-header
        eyebrow="Konten Website"
        title="Profil Pesantren"
        description="Perbarui konten beranda, sejarah, visi misi, dan informasi pengasuh yang tampil di halaman publik."
    />

    <form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        <section class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-sm font-bold uppercase tracking-[0.15em] text-slate-500">Identitas Website</h2>

            <div x-data="{ logoPreview: null }" class="mt-5 grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <label for="site_logo" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Logo Website</label>
                    <input
                        id="site_logo"
                        name="site_logo"
                        type="file"
                        accept="image/png,image/jpeg,image/svg+xml,image/webp"
                        class="mt-2 block w-full text-xs text-slate-600 file:mr-3 file:rounded-full file:border-0 file:bg-emerald-700 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-white hover:file:bg-emerald-800"
                        @change="if (logoPreview) URL.revokeObjectURL(logoPreview); logoPreview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : null"
                    >
                    <p class="mt-1.5 text-xs text-slate-500">PNG, JPG, WEBP, atau SVG. Maksimal 2 MB. Logo tampil di header situs.</p>

                    @error('site_logo')
                        <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <span class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Pratinjau Logo</span>

                    <div class="mt-2 flex h-28 items-center justify-center rounded-2xl border border-slate-100 bg-slate-50 p-4">
                        <img x-show="logoPreview" x-cloak :src="logoPreview" alt="Pratinjau logo baru" class="h-16 w-16 object-contain">
                        <div x-show="! logoPreview">
                            <x-landing.logo :src="$settings['site_logo']" class="h-16 w-16" />
                        </div>
                    </div>

                    <p class="mt-2 text-xs text-slate-500">Pratinjau muncul otomatis setelah memilih file baru.</p>
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-sm font-bold uppercase tracking-[0.15em] text-slate-500">Beranda &amp; Statistik</h2>

            <div class="mt-5 space-y-5">
                <div>
                    <label for="hero_title" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Judul Utama</label>
                    <input id="hero_title" name="hero_title" type="text" value="{{ old('hero_title', $settings['hero_title']) }}" class="field-input mt-2" required>
                </div>

                <div>
                    <label for="hero_subtitle" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Deskripsi Singkat</label>
                    <textarea id="hero_subtitle" name="hero_subtitle" rows="3" class="field-input mt-2" required>{{ old('hero_subtitle', $settings['hero_subtitle']) }}</textarea>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label for="hero_year" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Tahun Berdiri</label>
                        <input id="hero_year" name="hero_year" type="text" value="{{ old('hero_year', $settings['hero_year']) }}" class="field-input mt-2" required>
                    </div>

                    <div>
                        <label for="target_juz" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Target Juz</label>
                        <input id="target_juz" name="target_juz" type="text" value="{{ old('target_juz', $settings['target_juz']) }}" class="field-input mt-2" required>
                    </div>

                    <div>
                        <label for="total_santri" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Jumlah Santri</label>
                        <input id="total_santri" name="total_santri" type="text" value="{{ old('total_santri', $settings['total_santri']) }}" class="field-input mt-2" required>
                    </div>

                    <div>
                        <label for="total_pengajar" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Jumlah Pengajar</label>
                        <input id="total_pengajar" name="total_pengajar" type="text" value="{{ old('total_pengajar', $settings['total_pengajar']) }}" class="field-input mt-2" required>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-sm font-bold uppercase tracking-[0.15em] text-slate-500">Sejarah, Visi &amp; Misi</h2>

            <div class="mt-5 space-y-5">
                <div>
                    <label for="history" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Sejarah Singkat</label>
                    <textarea id="history" name="history" rows="4" class="field-input mt-2" required>{{ old('history', $settings['history']) }}</textarea>
                </div>

                <div>
                    <label for="vision" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Visi</label>
                    <textarea id="vision" name="vision" rows="3" class="field-input mt-2" required>{{ old('vision', $settings['vision']) }}</textarea>
                </div>

                <div>
                    <label for="missions" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Misi</label>
                    <textarea id="missions" name="missions" rows="5" class="field-input mt-2" required>{{ old('missions', implode("\n", $missions)) }}</textarea>
                    <p class="mt-2 text-xs text-slate-500">Tuliskan satu poin misi per baris.</p>
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-sm font-bold uppercase tracking-[0.15em] text-slate-500">Pengasuh Pesantren</h2>

            <div class="mt-5 grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="leader_name" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Nama Pengasuh</label>
                            <input id="leader_name" name="leader_name" type="text" value="{{ old('leader_name', $settings['leader_name']) }}" class="field-input mt-2" required>
                        </div>

                        <div>
                            <label for="leader_title" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Jabatan</label>
                            <input id="leader_title" name="leader_title" type="text" value="{{ old('leader_title', $settings['leader_title']) }}" class="field-input mt-2" required>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="leader_since" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Keterangan Mengasuh</label>
                        <input id="leader_since" name="leader_since" type="text" value="{{ old('leader_since', $settings['leader_since']) }}" class="field-input mt-2" required>
                    </div>

                    <div class="mt-4">
                        <label for="leader_quote" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Kutipan / Pesan</label>
                        <textarea id="leader_quote" name="leader_quote" rows="4" class="field-input mt-2" required>{{ old('leader_quote', $settings['leader_quote']) }}</textarea>
                    </div>
                </div>

                <div>
                    <span class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Foto Pengasuh</span>

                    <div class="mt-2 overflow-hidden rounded-2xl border border-slate-100 bg-slate-50">
                        <x-landing.smart-image
                            src="{{ $settings['leader_photo'] }}"
                            alt="{{ $settings['leader_name'] }}"
                            label="Foto Pengasuh"
                            class="aspect-[4/5] w-full"
                        />
                    </div>

                    <input id="leader_photo" name="leader_photo" type="file" accept="image/jpeg,image/png,image/webp" class="mt-3 block w-full text-xs text-slate-600 file:mr-3 file:rounded-full file:border-0 file:bg-emerald-700 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-white hover:file:bg-emerald-800">
                    <p class="mt-1.5 text-xs text-slate-500">JPG, PNG, atau WEBP. Maksimal 2 MB.</p>
                </div>
            </div>
        </section>

        <div class="flex flex-wrap items-center justify-end gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </div>
    </form>
@endsection
