@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1">Manajemen Kategori</h3>
        <p class="text-muted mb-0">Kelola kategori produk Es Teh Jumbo.</p>
    </div>

    <a href="{{ route('categories.create') }}" class="btn btn-success rounded-3">
        <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-warning alert-dismissible fade show rounded-3">
        <i class="bi bi-exclamation-triangle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-2">Total Kategori</p>
                    <h4 class="fw-bold mb-0">{{ $categories->count() }}</h4>
                </div>
                <i class="bi bi-tags fs-2 text-success"></i>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h5 class="fw-bold mb-1">Daftar Kategori</h5>
                <p class="text-muted small mb-0">Informasi kategori produk yang terdaftar.</p>
            </div>

            <div class="input-group" style="max-width: 260px;">
                <span class="input-group-text bg-light border-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="searchCategory"
                       class="form-control bg-light border-0"
                       placeholder="Cari kategori...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted small">
                        <th width="65">No.</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Dibuat</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody id="categoryTable">
                    @forelse ($categories as $category)
                        <tr class="category-row">
                            <td class="text-muted">{{ $loop->iteration }}</td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                                         style="width: 38px; height: 38px; background: #eaf3ed; color: #1D604B;">
                                        <i class="bi bi-tag"></i>
                                    </div>
                                    <span class="fw-semibold">{{ $category->name }}</span>
                                </div>
                            </td>

                            <td class="text-muted">
                                {{ $category->description ?: '-' }}
                            </td>

                            <td class="text-muted small">
                                {{ $category->created_at->format('d/m/Y') }}
                            </td>

                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('categories.edit', $category) }}"
                                       class="btn btn-sm btn-light text-primary rounded-3"
                                       title="Edit kategori">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('categories.destroy', $category) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-light text-danger rounded-3"
                                                title="Hapus kategori">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-tags fs-1 text-muted"></i>
                                <p class="text-muted mt-3 mb-0">Belum ada kategori.</p>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="noCategoryResult" class="d-none">
                        <td colspan="5" class="text-center text-muted py-4">
                            Kategori tidak ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const searchCategory = document.getElementById('searchCategory');
    const categoryRows = document.querySelectorAll('.category-row');
    const noCategoryResult = document.getElementById('noCategoryResult');

    searchCategory.addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        let visibleCount = 0;

        categoryRows.forEach(row => {
            const match = row.textContent.toLowerCase().includes(keyword);

            row.classList.toggle('d-none', !match);

            if (match) visibleCount++;
        });

        noCategoryResult.classList.toggle('d-none', visibleCount > 0);
    });
</script>
@endpush
