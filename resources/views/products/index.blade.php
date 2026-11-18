@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Manajemen Produk</h4>
            <p class="text-muted mb-0">Kelola produk Es Teh Jumbo.</p>
        </div>

        <a href="{{ route('products.create') }}" class="btn btn-success rounded-3 px-3">
            <i class="bi bi-plus-lg me-1"></i> Tambah Produk
        </a>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Statistik --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Produk</p>
                            <h3 class="fw-bold mb-0">{{ $products->count() }}</h3>
                        </div>
                        <div class="rounded-3 p-3 bg-success bg-opacity-10 text-success">
                            <i class="bi bi-cup-straw fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Produk Tersedia</p>
                            <h3 class="fw-bold mb-0">
                                {{ $products->where('is_available', true)->count() }}
                            </h3>
                        </div>
                        <div class="rounded-3 p-3 bg-success bg-opacity-10 text-success">
                            <i class="bi bi-check-circle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Tidak Tersedia</p>
                            <h3 class="fw-bold mb-0">
                                {{ $products->where('is_available', false)->count() }}
                            </h3>
                        </div>
                        <div class="rounded-3 p-3 bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-x-circle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Produk --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <h5 class="fw-bold mb-1">Daftar Produk</h5>
                    <p class="text-muted small mb-0">Semua produk yang terdaftar.</p>
                </div>

                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" id="searchProduct"
                           class="form-control bg-light border-start-0"
                           placeholder="Cari produk...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">No.</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="productTable">
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <div class="fw-semibold">{{ $product->name }}</div>
                                    <small class="text-muted">
                                        {{ $product->description ?: 'Tidak ada deskripsi' }}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $product->category->name ?? '-' }}
                                    </span>
                                </td>

                                <td class="fw-semibold">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>

                                <td>
                                    @if ($product->is_available)
                                        <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2">
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger px-3 py-2">
                                            Tidak tersedia
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- Atur Resep --}}
                                        <a href="{{ route('product-ingredients.index', $product) }}"
                                           class="btn btn-sm btn-outline-success rounded-3"
                                           title="Atur Resep">
                                            <i class="bi bi-journal-text"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('products.edit', $product) }}"
                                           class="btn btn-sm btn-outline-warning rounded-3"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        {{-- Hapus --}}
                                        <form action="{{ route('products.destroy', $product) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger rounded-3"
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-box-seam fs-1 text-muted"></i>
                                    <p class="text-muted mt-2 mb-0">Belum ada produk.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('searchProduct').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();

        document.querySelectorAll('#productTable tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(keyword)
                ? ''
                : 'none';
        });
    });
</script>
@endpush
