@extends('layouts.admin')

@section('title', 'Edit Kegiatan — Admin Nurur Rahmah')

@section('content')
    <x-admin.page-header
        eyebrow="Kegiatan & Program"
        title="Edit Kegiatan"
        description="Perbarui informasi kegiatan yang tampil di halaman publik."
    />

    <form method="POST" action="{{ route('admin.kegiatan.update', $kegiatan) }}" enctype="multipart/form-data" class="mt-6 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
        @csrf
        @method('PUT')

        @include('admin.kegiatan._form', ['kegiatan' => $kegiatan])

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3 border-t border-slate-100 pt-5">
            <a href="{{ route('admin.kegiatan.index') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </div>
    </form>
@endsection
