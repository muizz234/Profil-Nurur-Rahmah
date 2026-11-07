@extends('layouts.admin')

@section('title', 'Edit Berita — Admin Nurur Rahmah')

@section('content')
    <x-admin.page-header
        eyebrow="Berita & Artikel"
        title="Edit Berita"
        description="Perbarui isi dan status publikasi berita."
    />

    <form method="POST" action="{{ route('admin.berita.update', $berita) }}" enctype="multipart/form-data" class="mt-6 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
        @csrf
        @method('PUT')

        @include('admin.berita._form', ['berita' => $berita])

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3 border-t border-slate-100 pt-5">
            <a href="{{ route('admin.berita.index') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </div>
    </form>
@endsection
