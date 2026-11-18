@extends('layouts.app')

@section('title', 'Edit Bahan Baku')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Bahan Baku</h4>
            <p class="text-muted mb-0">
                Perbarui informasi dan persediaan bahan baku.
            </p>
        </div>

        <a href="{{ route('ingredients.index') }}"
           class="btn btn-light border rounded-3">
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
                            <h5 class="fw-bold mb-1">Informasi Bahan Baku</h5>
                            <small class="text-muted">
                                Perbarui informasi bahan baku di bawah ini.
                            </small>
                        </div>
                    </div>

                    <form action="{{ route('ingredients.update', $ingredient) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                Nama Bahan <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control rounded-3 @error('name') is-invalid @enderror"
                                value="{{ old('name', $ingredient->name) }}"
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
                                value="{{ old('unit', $ingredient->unit) }}"
                                placeholder="Contoh: gram, ml, kg, liter"
                                required
                            >

                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="stock" class="form-label fw-semibold">
                                    Stok Saat Ini <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="number"
                                    id="stock"
                                    name="stock"
                                    step="0.01"
                                    min="0"
                                    class="form-control rounded-3 @error('stock') is-invalid @enderror"
                                    value="{{ old('stock', $ingredient->stock) }}"
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
                                    value="{{ old('minimum_stock', $ingredient->minimum_stock) }}"
                                    required
                                >

                                @error('minimum_stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-warning border-0 rounded-3 mt-4 mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            <small>
                                Perubahan stok melalui halaman ini tidak mencatat riwayat stok masuk atau keluar.
                                Gunakan fitur Manajemen Stok untuk pencatatan pergerakan stok.
                            </small>
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
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- Detail Bahan --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="rounded-3 d-flex align-items-center justify-content-center mb-3"
                         style="width: 44px; height: 44px; background: #eaf4ed; color: #1D604B;">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>

                    <h6 class="fw-bold mb-3">Detail Persediaan</h6>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Nama Bahan</small>
                        <span class="fw-semibold">{{ $ingredient->name }}</span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Stok Saat Ini</small>
                        <span class="fw-bold fs-5">
                            {{ number_format((float) $ingredient->stock, 2, ',', '.') }}
                            {{ $ingredient->unit }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Stok Minimum</small>
                        <span class="fw-semibold">
                            {{ number_format((float) $ingredient->minimum_stock, 2, ',', '.') }}
                            {{ $ingredient->unit }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-2">Status Persediaan</small>

                        @if($ingredient->isLowStock())
                            <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                Stok Menipis
                            </span>
                        @else
                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                <i class="bi bi-check-circle me-1"></i>
                                Aman
                            </span>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
