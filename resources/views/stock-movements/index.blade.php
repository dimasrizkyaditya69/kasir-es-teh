@extends('layouts.app')

@section('title', 'Riwayat Pergerakan Stok')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Riwayat Pergerakan Stok</h4>
            <p class="text-muted mb-0">
                Pantau seluruh aktivitas stok masuk dan keluar bahan baku.
            </p>
        </div>

        <a href="{{ route('stock-movements.create') }}"
           class="btn text-white rounded-3 px-3"
           style="background: #1D604B;">
            <i class="bi bi-plus-lg me-1"></i>
            Catat Pergerakan Stok
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
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Total Pergerakan</small>
                            <h3 class="fw-bold mb-0 mt-2">
                                {{ $movements->count() }}
                            </h3>
                        </div>
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                             style="width: 48px; height: 48px; background: #eaf4ed; color: #1D604B;">
                            <i class="bi bi-arrow-left-right fs-4"></i>
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
                            <small class="text-muted">Transaksi Stok Masuk</small>
                            <h3 class="fw-bold text-success mb-0 mt-2">
                                {{ $movements->where('type', 'in')->count() }}
                            </h3>
                        </div>
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                             style="width: 48px; height: 48px; background: #eaf4ed; color: #198754;">
                            <i class="bi bi-box-arrow-in-down fs-4"></i>
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
                            <small class="text-muted">Transaksi Stok Keluar</small>
                            <h3 class="fw-bold text-danger mb-0 mt-2">
                                {{ $movements->where('type', 'out')->count() }}
                            </h3>
                        </div>
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                             style="width: 48px; height: 48px; background: #fcebea; color: #dc3545;">
                            <i class="bi bi-box-arrow-up fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Tabel Riwayat --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <h5 class="fw-bold mb-1">Daftar Pergerakan Stok</h5>
                    <small class="text-muted">
                        Riwayat aktivitas persediaan bahan baku.
                    </small>
                </div>

                <div class="position-relative" style="width: 260px; max-width: 100%;">
                    <i class="bi bi-search position-absolute top-50 translate-middle-y text-muted"
                       style="left: 12px;"></i>
                    <input type="text"
                           id="searchMovement"
                           class="form-control rounded-3 ps-5"
                           placeholder="Cari riwayat stok...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="movementTable">
                    <thead>
                        <tr class="text-muted small">
                            <th class="py-3">No</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Nama Bahan</th>
                            <th class="py-3">Jenis Pergerakan</th>
                            <th class="py-3">Jumlah</th>
                            <th class="py-3">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($movements as $movement)
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $movement->created_at->format('d/m/Y') }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $movement->created_at->format('H:i') }}
                                    </small>
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $movement->ingredient->name }}
                                    </div>
                                    <small class="text-muted">
                                        Bahan baku
                                    </small>
                                </td>

                                <td>
                                    @if($movement->type === 'in')
                                        <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                            <i class="bi bi-arrow-down-circle me-1"></i>
                                            Stok Masuk
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">
                                            <i class="bi bi-arrow-up-circle me-1"></i>
                                            Stok Keluar
                                        </span>
                                    @endif
                                </td>

                                <td class="fw-semibold">
                                    {{ number_format((float) $movement->quantity, 2, ',', '.') }}
                                    {{ $movement->ingredient->unit }}
                                </td>

                                <td>
                                    <span class="text-muted small">
                                        {{ $movement->description ?: '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    <span class="text-muted">
                                        Belum ada riwayat pergerakan stok.
                                    </span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div id="emptySearch" class="text-center text-muted py-4 d-none">
                    Riwayat pergerakan stok tidak ditemukan.
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('searchMovement');
    const tableRows = document.querySelectorAll('#movementTable tbody tr');
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
