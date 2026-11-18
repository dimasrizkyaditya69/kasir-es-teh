@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="mb-4">
        <a href="{{ route('products.index') }}"
           class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Produk
        </a>

        <h4 class="fw-bold mt-2 mb-1">Edit Produk</h4>
        <p class="text-muted mb-0">Perbarui informasi produk yang sudah terdaftar.</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-3 p-3 bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-pencil-square fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Informasi Produk</h5>
                            <p class="text-muted small mb-0">
                                Ubah informasi produk sesuai kebutuhan.
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('products.update', $product) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Kategori --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Kategori <span class="text-danger">*</span>
                            </label>

                            <select name="category_id"
                                    class="form-select rounded-3 @error('category_id') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Kategori --</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama Produk --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nama Produk <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control rounded-3 @error('name') is-invalid @enderror"
                                   value="{{ old('name', $product->name) }}"
                                   required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>

                            <textarea name="description"
                                      class="form-control rounded-3 @error('description') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Masukkan deskripsi produk...">{{ old('description', $product->description) }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Harga --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Harga Produk (Rp) <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">
                                <span class="input-group-text bg-light">Rp</span>

                                <input type="number"
                                       name="price"
                                       class="form-control rounded-end-3 @error('price') is-invalid @enderror"
                                       value="{{ old('price', $product->price) }}"
                                       min="0"
                                       step="0.01"
                                       required>

                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Status Produk <span class="text-danger">*</span>
                            </label>

                            <select name="is_available"
                                    class="form-select rounded-3 @error('is_available') is-invalid @enderror"
                                    required>

                                <option value="1"
                                    {{ old('is_available', (string) (int) $product->is_available) == '1' ? 'selected' : '' }}>
                                    Tersedia
                                </option>

                                <option value="0"
                                    {{ old('is_available', (string) (int) $product->is_available) == '0' ? 'selected' : '' }}>
                                    Tidak tersedia
                                </option>
                            </select>

                            @error('is_available')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('products.index') }}"
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

        {{-- Informasi tambahan --}}
        <div class="col-lg-4 mt-3 mt-lg-0">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="rounded-3 p-3 bg-success bg-opacity-10 text-success d-inline-block mb-3">
                        <i class="bi bi-info-circle fs-4"></i>
                    </div>

                    <h6 class="fw-bold">Informasi Produk</h6>

                    <p class="text-muted small mb-3">
                        Produk yang sedang diedit:
                    </p>

                    <div class="bg-light rounded-3 p-3">
                        <div class="small text-muted">Nama Produk</div>
                        <div class="fw-semibold">{{ $product->name }}</div>

                        <hr>

                        <div class="small text-muted">Harga Saat Ini</div>
                        <div class="fw-semibold">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    </div>

                    <p class="text-muted small mt-3 mb-0">
                        Pastikan perubahan informasi sudah benar sebelum disimpan.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
