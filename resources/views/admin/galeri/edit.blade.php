@extends('layouts.admin')

@section('title', 'Edit Foto — Admin Nurur Rahmah')

@section('content')
    <x-admin.page-header
        eyebrow="Galeri"
        title="Edit Foto Galeri"
        description="Perbarui judul, keterangan, atau ganti foto galeri."
    />

    <form method="POST" action="{{ route('admin.galeri.update', $galeri) }}" enctype="multipart/form-data" class="mt-6 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
        @csrf
        @method('PUT')

        @include('admin.galeri._form', ['galeri' => $galeri])

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3 border-t border-slate-100 pt-5">
            <a href="{{ route('admin.galeri.index') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </div>
    </form>
@endsection
