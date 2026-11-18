@extends('layouts.app')

@section('title', 'Edit Bahan Resep')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <div class="mb-2">
                <a href="{{ route('product-ingredients.index', $productIngredient->product_id) }}"
                   class="text-decoration-none text-muted">
                    <i class="bi bi-arrow-left"></i> Kembali ke Resep
                </a>
            </div>

            <h3 class="fw-bold mb-1">Edit Komposisi Bahan</h3>
            <p class="text-muted mb-0">
                Perbarui jumlah kebutuhan bahan baku produk.
            </p>
        </div>

        <div class="rounded-3 px-3 py-2"
             style="background: #EAF3E5; color: #245B43;">
            <i class="bi bi-pencil-square me-1"></i>
            Edit Resep
        </div>
    </div>

    {{-- Product Information --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                     style="width: 52px; height: 52px; background: #EAF3E5; color: #245B43;">
                    <i class="bi bi-cup-straw fs-3"></i>
                </div>

                <div>
                    <small class="text-muted">Produk</small>
                    <h5 class="fw-bold mb-0">
                        {{ $productIngredient->product->name }}
                    </h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Form --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">

            <div class="mb-4">
                <h5 class="fw-bold mb-1">Informasi Komposisi</h5>
                <p class="text-muted small mb-0">
                    Sesuaikan jumlah bahan yang dibutuhkan untuk satu produk.
                </p>
            </div>

            <form action="{{ route('product-ingredients.update', $productIngredient) }}"
                  method="POST">
                @csrf
                @method('PUT')

                {{-- Bahan Baku --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Bahan Baku</label>

                    <input type="text"
                           class="form-control rounded-3 py-2 bg-light"
                           value="{{ $productIngredient->ingredient->name }} ({{ $productIngredient->ingredient->unit }})"
                           disabled>

                    <small class="text-muted">
                        Bahan baku tidak dapat diganti dari halaman ini.
                    </small>
                </div>

                {{-- Quantity --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Jumlah Kebutuhan per Produk
                    </label>

                    <div class="input-group">
                        <input type="number"
                               name="quantity"
                               step="0.01"
                               min="0.01"
                               value="{{ old('quantity', $productIngredient->quantity) }}"
                               class="form-control rounded-start-3 py-2 @error('quantity') is-invalid @enderror"
                               placeholder="Contoh: 10"
                               required>

                        <span class="input-group-text rounded-end-3 bg-light">
                            {{ $productIngredient->ingredient->unit }}
                        </span>

                        @error('quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <small class="text-muted d-block mt-2">
                        Masukkan jumlah bahan yang diperlukan untuk membuat satu produk.
                    </small>
                </div>

                {{-- Info --}}
                <div class="alert rounded-3 border-0"
                     style="background: #F1F6ED; color: #42634D;">
                    <i class="bi bi-info-circle me-2"></i>
                    Perubahan komposisi akan menjadi acuan pengurangan stok
                    pada transaksi berikutnya.
                </div>

                {{-- Actions --}}
                <div class="d-flex flex-wrap justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('product-ingredients.index', $productIngredient->product_id) }}"
                       class="btn btn-light border rounded-3 px-4">
                        Batal
                    </a>

                    <button type="submit"
                            class="btn btn-success rounded-3 px-4">
                        <i class="bi bi-check-lg me-1"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
