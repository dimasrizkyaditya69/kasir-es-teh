@extends('layouts.app')

@section('title', 'Manajemen Bahan Baku')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Manajemen Bahan Baku</h4>
            <p class="text-muted mb-0">
                Kelola persediaan dan pantau stok bahan baku produk.
            </p>
        </div>

        <a href="{{ route('ingredients.create') }}"
           class="btn text-white rounded-3 px-3"
           style="background: #1D604B;">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Bahan Baku
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Statistik --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div cla
            ss="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Total Bahan Baku</small>
                            <h3 class="fw-bold mb-0 mt-2">
                                {{ $ingredients->count() }}
                            </h3>
                        </div>
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                             style="width: 48px; height: 48px; background: #eaf4ed; color: #1D604B;">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Stok Aman</small>
                            <h3 class="fw-bold text-success mb-0 mt-2">
                                {{ $ingredients->filter(fn($item) => !$item->isLowStock())->count() }}
                            </h3>
                        </div>
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                             style="width: 48px; height: 48px; background: #eaf4ed; color: #198754;">
                            <i class="bi bi-check-circle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Stok Menipis</small>
                            <h3 class="fw-bold text-danger mb-0 mt-2">
                                {{ $ingredients->filter(fn($item) => $item->isLowStock())->count() }}
                            </h3>
                        </div>
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                             style="width: 48px; height: 48px; background: #fcebea; color: #dc3545;">
                            <i class="bi bi-exclamation-triangle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Tabel Bahan Baku --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <h5 class="fw-bold mb-1">Daftar Bahan Baku</h5>
                    <small class="text-muted">Informasi persediaan seluruh bahan baku.</small>
                </div>

                <div class="position-relative" style="width: 260px; max-width: 100%;">
                    <i class="bi bi-search position-absolute top-50 translate-middle-y text-muted"
                       style="left: 12px;"></i>
                    <input type="text"
                           id="searchIngredient"
                           class="form-control rounded-3 ps-5"
                           placeholder="Cari bahan baku...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle table-hover" id="ingredientTable">
                    <thead>
                        <tr class="text-muted small">
                            <th class="py-3">No</th>
                            <th class="py-3">Nama Bahan</th>
                            <th class="py-3">Satuan</th>
                            <th class="py-3">Stok Saat Ini</th>
                            <th class="py-3">Stok Minimum</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($ingredients as $ingredient)
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>

                                <td>
                                    <div class="fw-semibold">{{ $ingredient->name }}</div>
                                    <small class="text-muted">Bahan baku produk</small>
                                </td>

                                <td>{{ $ingredient->unit }}</td>

                                <td class="fw-semibold">
                                    {{ number_format((float) $ingredient->stock, 2, ',', '.') }}
                                </td>

                                <td>
                                    {{ number_format((float) $ingredient->minimum_stock, 2, ',', '.') }}
                                </td>

                                <td>
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
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('ingredients.edit', $ingredient) }}"
                                           class="btn btn-sm btn-light border rounded-3"
                                           title="Edit">
                                            <i class="bi bi-pencil-square text-primary"></i>
                                        </a>

                                        <form action="{{ route('ingredients.destroy', $ingredient) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus bahan baku {{ $ingredient->name }}?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-light border rounded-3"
                                                    title="Hapus">
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    <span class="text-muted">Belum ada data bahan baku.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div id="emptySearch" class="text-center text-muted py-4 d-none">
                    Bahan baku tidak ditemukan.
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('searchIngredient');
    const tableRows = document.querySelectorAll('#ingredientTable tbody tr');
    const emptySearch = document.getElementById('emptySearch');

    searchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase().trim();
        let visibleCount = 0;

        tableRows.forEach(row => {
            const match = row.innerText.toLowerCase().includes(keyword);

            row.style.display = match ? '' : 'none';

            if (match) visibleCount++;
        });

        emptySearch.classList.toggle('d-none', visibleCount > 0);
    });
</script>
@endpush
