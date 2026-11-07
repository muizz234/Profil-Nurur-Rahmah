@extends('layouts.admin')

@section('title', 'Tulis Berita — Admin Nurur Rahmah')

@section('content')
    <x-admin.page-header
        eyebrow="Berita & Artikel"
        title="Tulis Berita"
        description="Buat berita atau artikel baru untuk ditampilkan di halaman publik."
    />

    <form method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data" class="mt-6 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
        @csrf

        @include('admin.berita._form', ['berita' => null])

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3 border-t border-slate-100 pt-5">
            <a href="{{ route('admin.berita.index') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary">Simpan Berita</button>
        </div>
    </form>
@endsection
