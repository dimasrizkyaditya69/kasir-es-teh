@extends('layouts.app')

@section('title', 'Resep Produk')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Resep Produk</h4>
            <p class="text-muted mb-0">
                Kelola komposisi bahan baku untuk {{ $product->name }}.
            </p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('products.index') }}"
               class="btn btn-outline-secondary rounded-3">
                <i class="bi bi-arrow-left me-1"></i>
                Kembali
            </a>

            <a href="{{ route('product-ingredients.create', $product) }}"
               class="btn btn-success rounded-3 px-3">
                <i class="bi bi-plus-lg me-1"></i>
                Tambah Bahan
            </a>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0"
             role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0"
             role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Informasi Produk --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 p-3 bg-success bg-opacity-10 text-success">
                            <i class="bi bi-cup-straw fs-3"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">Nama Produk</p>
                            <h5 class="fw-bold mb-0">{{ $product->name }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 p-3 bg-success bg-opacity-10 text-success">
                            <i class="bi bi-list-check fs-3"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">Total Komposisi Bahan</p>
                            <h5 class="fw-bold mb-0">
                                {{ $product->ingredients->count() }} Bahan
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Resep --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <h5 class="fw-bold mb-1">Komposisi Bahan Baku</h5>
                    <p class="text-muted small mb-0">
                        Kebutuhan bahan baku untuk setiap satu produk.
                    </p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">No.</th>
                            <th>Nama Bahan Baku</th>
                            <th>Kebutuhan per Produk</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($product->ingredients as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-3 p-2 bg-success bg-opacity-10 text-success">
                                            <i class="bi bi-box-seam"></i>
                                        </div>
                                        <span class="fw-semibold">
                                            {{ $item->ingredient->name }}
                                        </span>
                                    </div>
                                </td>

                                <td>
                                    <span class="fw-semibold">
                                        {{ number_format((float) $item->quantity, 2, ',', '.') }}
                                    </span>
                                    <span class="text-muted">
                                        {{ $item->ingredient->unit }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- Edit --}}
                                        <a href="{{ route('product-ingredients.edit', $item) }}"
                                           class="btn btn-sm btn-outline-warning rounded-3"
                                           title="Edit komposisi">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        {{-- Hapus --}}
                                        <form action="{{ route('product-ingredients.destroy', $item) }}"
                                              method="POST"
                                              onsubmit="return confirm('Hapus bahan ini dari resep produk?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger rounded-3"
                                                    title="Hapus komposisi">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="bi bi-journal-x text-muted"
                                           style="font-size: 3rem;"></i>
                                    </div>
                                    <h6 class="fw-bold">Belum Ada Resep</h6>
                                    <p class="text-muted small mb-3">
                                        Produk ini belum memiliki komposisi bahan baku.
                                        Tambahkan bahan untuk mulai mengatur resep.
                                    </p>
                                    <a href="{{ route('product-ingredients.create', $product) }}"
                                       class="btn btn-success btn-sm rounded-3">
                                        <i class="bi bi-plus-lg me-1"></i>
                                        Tambah Bahan Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- Informasi --}}
    <div class="alert border-0 rounded-3 mt-4"
         style="background: #eaf3ee; color: #24533f;">
        <div class="d-flex gap-2">
            <i class="bi bi-info-circle-fill mt-1"></i>
            <div>
                <strong>Informasi Resep</strong>
                <p class="small mb-0">
                    Jumlah komposisi menunjukkan kebutuhan bahan baku
                    untuk membuat satu unit produk. Sistem menggunakan
                    komposisi ini untuk menghitung pengurangan stok
                    ketika transaksi berhasil dilakukan.
                </p>
            </div>
        </div>
    </div>

</div>
@endsection
