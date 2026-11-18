@extends('layouts.app')

@section('title', 'Tambah Bahan Resep')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <a href="{{ route('product-ingredients.index', $product) }}"
                   class="text-decoration-none text-muted">
                    <i class="bi bi-arrow-left"></i> Kembali ke Resep
                </a>
            </div>
            <h3 class="fw-bold mb-1">Tambah Bahan ke Resep</h3>
            <p class="text-muted mb-0">
                Tambahkan kebutuhan bahan baku untuk satu produk.
            </p>
        </div>

        <div class="rounded-3 px-3 py-2"
             style="background: #EAF3E5; color: #245B43;">
            <i class="bi bi-journal-plus me-1"></i>
            Manajemen Resep
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
                    <small class="text-muted">Produk yang sedang diatur</small>
                    <h5 class="fw-bold mb-0">{{ $product->name }}</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">

            <div class="mb-4">
                <h5 class="fw-bold mb-1">Informasi Bahan Baku</h5>
                <p class="text-muted small mb-0">
                    Pilih bahan dan tentukan jumlah yang diperlukan untuk satu produk.
                </p>
            </div>

            @if($ingredients->isEmpty())

                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-box-seam display-3 text-muted"></i>
                    </div>
                    <h5 class="fw-bold">Belum Ada Bahan Baku</h5>
                    <p class="text-muted">
                        Tambahkan bahan baku terlebih dahulu sebelum membuat resep.
                    </p>
                    <a href="{{ route('ingredients.create') }}"
                       class="btn btn-success rounded-3 px-4">
                        <i class="bi bi-plus-lg me-1"></i>
                        Tambah Bahan Baku
                    </a>
                </div>

            @else

                <form action="{{ route('product-ingredients.store', $product) }}"
                      method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Pilih Bahan Baku
                        </label>

                        <select name="ingredient_id"
                                class="form-select rounded-3 py-2 @error('ingredient_id') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Bahan Baku --</option>

                            @foreach($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}"
                                    {{ old('ingredient_id') == $ingredient->id ? 'selected' : '' }}>
                                    {{ $ingredient->name }} ({{ $ingredient->unit }})
                                </option>
                            @endforeach
                        </select>

                        @error('ingredient_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Jumlah Kebutuhan per Produk
                        </label>

                        <div class="input-group">
                            <input type="number"
                                   name="quantity"
                                   step="0.01"
                                   min="0.01"
                                   value="{{ old('quantity') }}"
                                   class="form-control rounded-start-3 py-2 @error('quantity') is-invalid @enderror"
                                   placeholder="Contoh: 10"
                                   required>

                            <span class="input-group-text rounded-end-3 bg-light">
                                Jumlah
                            </span>

                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <small class="text-muted d-block mt-2">
                            Masukkan jumlah bahan yang dibutuhkan untuk membuat satu produk.
                            Satuan mengikuti satuan bahan baku yang dipilih.
                        </small>
                    </div>

                    <div class="alert rounded-3 border-0"
                         style="background: #F1F6ED; color: #42634D;">
                        <i class="bi bi-info-circle me-2"></i>
                        Kebutuhan bahan ini akan digunakan sebagai dasar pengurangan stok
                        otomatis ketika produk terjual.
                    </div>

                    <div class="d-flex flex-wrap justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('product-ingredients.index', $product) }}"
                           class="btn btn-light border rounded-3 px-4">
                            Batal
                        </a>

                        <button type="submit"
                                class="btn btn-success rounded-3 px-4">
                            <i class="bi bi-check-lg me-1"></i>
                            Simpan Bahan
                        </button>
                    </div>
                </form>

            @endif

        </div>
    </div>

</div>
@endsection
