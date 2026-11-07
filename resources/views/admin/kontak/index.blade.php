@extends('layouts.admin')

@section('title', 'Kontak & Lokasi — Admin Nurur Rahmah')

@section('content')
    <x-admin.page-header
        eyebrow="Konten Website"
        title="Kontak & Lokasi"
        description="Perbarui informasi kontak dan peta lokasi yang tampil di halaman publik."
    />

    <form method="POST" action="{{ route('admin.kontak.update') }}" class="mt-6 grid gap-6 lg:grid-cols-2">
        @csrf

        <section class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-sm font-bold uppercase tracking-[0.15em] text-slate-500">Informasi Kontak</h2>

            <div class="mt-5 space-y-5">
                <div>
                    <label for="address" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Alamat</label>
                    <textarea id="address" name="address" rows="3" class="field-input mt-2" required>{{ old('address', $settings['address']) }}</textarea>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="whatsapp" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">WhatsApp</label>
                        <input id="whatsapp" name="whatsapp" type="text" value="{{ old('whatsapp', $settings['whatsapp']) }}" class="field-input mt-2" required>
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $settings['email']) }}" class="field-input mt-2" required>
                    </div>
                </div>

                <div>
                    <label for="operational_hours" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Jam Operasional</label>
                    <input id="operational_hours" name="operational_hours" type="text" value="{{ old('operational_hours', $settings['operational_hours']) }}" class="field-input mt-2" required>
                </div>

                <div>
                    <label for="maps_embed" class="block text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Google Maps</label>
                    <textarea id="maps_embed" name="maps_embed" rows="5" class="field-input mt-2" required>{{ old('maps_embed', $settings['maps_embed']) }}</textarea>
                    <p class="mt-2 text-xs text-slate-500">Tempelkan URL embed Google Maps atau kode <code class="rounded bg-slate-100 px-1 py-0.5">&lt;iframe&gt;</code>. Sistem akan menyimpan URL-nya saja.</p>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap items-center justify-end gap-3 border-t border-slate-100 pt-5">
                <a href="{{ route('admin.dashboard') }}" class="btn-outline">Batal</a>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-sm font-bold uppercase tracking-[0.15em] text-slate-500">Pratinjau Peta</h2>

            <div class="mt-5 overflow-hidden rounded-xl border border-slate-100 bg-slate-50">
                <iframe
                    src="{{ old('maps_embed', $settings['maps_embed']) }}"
                    title="Pratinjau peta lokasi"
                    class="h-72 w-full"
                    style="border:0;"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </div>

            <p class="mt-3 text-xs leading-relaxed text-slate-500">
                Pratinjau mungkin tidak berubah sebelum perubahan disimpan. Pastikan URL embed diawali dengan
                <code class="rounded bg-slate-100 px-1 py-0.5">https://</code>.
            </p>
        </section>
    </form>
@endsection
