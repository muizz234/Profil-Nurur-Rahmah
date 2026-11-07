@extends('layouts.admin')

@section('title', 'Tambah Kegiatan — Admin Nurur Rahmah')

@section('content')
    <x-admin.page-header
        eyebrow="Kegiatan & Program"
        title="Tambah Kegiatan"
        description="Tambahkan kegiatan atau program baru yang akan tampil di halaman publik."
    />

    <form method="POST" action="{{ route('admin.kegiatan.store') }}" enctype="multipart/form-data" class="mt-6 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
        @csrf

        @include('admin.kegiatan._form', ['kegiatan' => null])

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3 border-t border-slate-100 pt-5">
            <a href="{{ route('admin.kegiatan.index') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary">Simpan Kegiatan</button>
        </div>
    </form>
@endsection
