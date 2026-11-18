@extends('layouts.app')

@section('title', 'Tambah Bahan Baku')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Tambah Bahan Baku</h4>
            <p class="text-muted mb-0">
                Tambahkan bahan baku baru ke persediaan.
            </p>
        </div>

        <a href="{{ route('ingredients.index') }}"
           class="btn btn-light border rounded-3">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>
    </div>

    <div class="row g-4">

        {{-- Form --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                             style="width: 48px; height: 48px; background: #eaf4ed; color: #1D604B;">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">Informasi Bahan Baku</h5>
                            <small class="text-muted">
                                Lengkapi informasi bahan baku di bawah ini.
                            </small>
                        </div>
                    </div>

                    <form action="{{ route('ingredients.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                Nama Bahan <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control rounded-3 @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="Contoh: Teh, Gula, Es Batu"
                                required
                                autofocus
                            >

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="unit" class="form-label fw-semibold">
                                Satuan <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                id="unit"
                                name="unit"
                                class="form-control rounded-3 @error('unit') is-invalid @enderror"
                                value="{{ old('unit') }}"
                                placeholder="Contoh: gram, ml, kg, liter"
                                required
                            >

                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <small class="text-muted">
                                Gunakan satuan yang konsisten untuk pencatatan stok.
                            </small>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="stock" class="form-label fw-semibold">
                                    Stok Awal <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="number"
                                    id="stock"
                                    name="stock"
                                    step="0.01"
                                    min="0"
                                    class="form-control rounded-3 @error('stock') is-invalid @enderror"
                                    value="{{ old('stock', 0) }}"
                                    required
                                >

                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="minimum_stock" class="form-label fw-semibold">
                                    Stok Minimum <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="number"
                                    id="minimum_stock"
                                    name="minimum_stock"
                                    step="0.01"
                                    min="0"
                                    class="form-control rounded-3 @error('minimum_stock') is-invalid @enderror"
                                    value="{{ old('minimum_stock', 0) }}"
                                    required
                                >

                                @error('minimum_stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('ingredients.index') }}"
                               class="btn btn-light border rounded-3 px-4">
                                Batal
                            </a>

                            <button type="submit"
                                    class="btn text-white rounded-3 px-4"
                                    style="background: #1D604B;">
                                <i class="bi bi-check-circle me-1"></i>
                                Simpan Bahan Baku
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- Informasi --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="rounded-3 d-flex align-items-center justify-content-center mb-3"
                         style="width: 44px; height: 44px; background: #eaf4ed; color: #1D604B;">
                        <i class="bi bi-lightbulb fs-4"></i>
                    </div>

                    <h6 class="fw-bold mb-3">Panduan Pengisian</h6>

                    <div class="d-flex gap-2 mb-3">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <small class="text-muted">
                            Masukkan nama bahan baku yang mudah dikenali.
                        </small>
                    </div>

                    <div class="d-flex gap-2 mb-3">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <small class="text-muted">
                            Tentukan satuan seperti gram, ml, kg, atau liter.
                        </small>
                    </div>

                    <div class="d-flex gap-2 mb-3">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <small class="text-muted">
                            Stok awal merupakan jumlah persediaan saat bahan didaftarkan.
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <i class="bi bi-exclamation-circle-fill text-warning"></i>
                        <small class="text-muted">
                            Stok minimum digunakan sebagai batas peringatan ketika persediaan menipis.
                        </small>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
