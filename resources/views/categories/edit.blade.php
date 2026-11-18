@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Kategori</h4>
            <p class="text-muted mb-0">
                Perbarui informasi kategori produk.
            </p>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-light border rounded-3">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>
    </div>

    <div class="row g-4">

        {{-- Form Edit --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                             style="width: 48px; height: 48px; background: #eaf4ed; color: #1D604B;">
                            <i class="bi bi-pencil-square fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Informasi Kategori</h5>
                            <small class="text-muted">
                                Ubah informasi kategori di bawah ini.
                            </small>
                        </div>
                    </div>

                    <form action="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control rounded-3 @error('name') is-invalid @enderror"
                                value="{{ old('name', $category->name) }}"
                                placeholder="Contoh: Teh Original"
                                required
                                autofocus
                            >

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">
                                Deskripsi
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                class="form-control rounded-3 @error('description') is-invalid @enderror"
                                rows="4"
                                placeholder="Masukkan deskripsi kategori (opsional)"
                            >{{ old('description', $category->description) }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <small class="text-muted">
                                Berikan keterangan singkat mengenai kategori produk.
                            </small>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('categories.index') }}"
                               class="btn btn-light border rounded-3 px-4">
                                Batal
                            </a>

                            <button type="submit"
                                    class="btn rounded-3 px-4 text-white"
                                    style="background: #1D604B;">
                                <i class="bi bi-check-circle me-1"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        {{-- Informasi Kategori --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="rounded-3 d-flex align-items-center justify-content-center mb-3"
                         style="width: 44px; height: 44px; background: #eaf4ed; color: #1D604B;">
                        <i class="bi bi-info-circle fs-4"></i>
                    </div>

                    <h6 class="fw-bold mb-3">Detail Kategori</h6>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Nama saat ini</small>
                        <span class="fw-semibold">{{ $category->name }}</span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Deskripsi saat ini</small>
                        <span class="text-muted small">
                            {{ $category->description ?: 'Belum ada deskripsi.' }}
                        </span>
                    </div>

                    <hr>

                    <p class="text-muted small mb-0">
                        Perubahan kategori akan langsung diterapkan pada produk yang menggunakan kategori ini.
                    </p>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
