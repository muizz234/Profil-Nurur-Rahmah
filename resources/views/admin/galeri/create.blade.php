@extends('layouts.admin')

@section('title', 'Unggah Foto — Admin Nurur Rahmah')

@section('content')
    <x-admin.page-header
        eyebrow="Galeri"
        title="Unggah Foto Galeri"
        description="Tambahkan dokumentasi kegiatan pesantren ke galeri publik."
    />

    <form method="POST" action="{{ route('admin.galeri.store') }}" enctype="multipart/form-data" class="mt-6 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
        @csrf

        @include('admin.galeri._form', ['galeri' => null])

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3 border-t border-slate-100 pt-5">
            <a href="{{ route('admin.galeri.index') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary">Unggah Foto</button>
        </div>
    </form>
@endsection
