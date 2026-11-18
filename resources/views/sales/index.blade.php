@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1">Riwayat Transaksi</h3>
        <p class="text-muted mb-0">
            Pantau dan periksa seluruh transaksi penjualan.
        </p>
    </div>

    <a href="{{ route('sales.create') }}" class="btn btn-success rounded-3">
        <i class="bi bi-plus-lg me-2"></i>Transaksi Baru
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success rounded-3">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
    </div>
@endif

{{-- RINGKASAN --}}
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-2">Total Transaksi</p>
                        <h4 class="fw-bold mb-0">{{ $sales->count() }}</h4>
                    </div>
                    <i class="bi bi-receipt fs-2 text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-2">Total Pendapatan</p>
                        <h4 class="fw-bold mb-0">
                            Rp {{ number_format($sales->where('status', 'completed')->sum('total_amount'), 0, ',', '.') }}
                        </h4>
                    </div>
                    <i class="bi bi-cash-stack fs-2 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TABEL TRANSAKSI --}}
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h5 class="fw-bold mb-1">Daftar Transaksi</h5>
                <p class="text-muted small mb-0">Seluruh transaksi yang tercatat dalam sistem.</p>
            </div>

            <div class="input-group" style="max-width: 280px;">
                <span class="input-group-text bg-light border-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="searchTransaction"
                       class="form-control bg-light border-0"
                       placeholder="Cari invoice atau kasir...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted small">
                        <th>No.</th>
                        <th>Invoice</th>
                        <th>Kasir</th>
                        <th>Total Belanja</th>
                        <th>Dibayar</th>
                        <th>Kembalian</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody id="transactionTable">
                    @forelse ($sales as $index => $sale)
                        <tr class="transaction-row">
                            <td class="text-muted">{{ $index + 1 }}</td>

                            <td>
                                <span class="fw-bold text-success">
                                    {{ $sale->invoice_number }}
                                </span>
                            </td>

                            <td>{{ $sale->user->name ?? '-' }}</td>

                            <td class="fw-semibold">
                                Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp {{ number_format($sale->paid_amount, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp {{ number_format($sale->change_amount, 0, ',', '.') }}
                            </td>

                            <td>
                                @if ($sale->status === 'completed')
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Selesai
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                @endif
                            </td>

                            <td class="text-muted small">
                                {{ $sale->created_at->format('d/m/Y') }}
                                <br>
                                {{ $sale->created_at->format('H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-receipt fs-1 text-muted"></i>
                                <p class="text-muted mt-3 mb-0">
                                    Belum ada transaksi penjualan.
                                </p>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="noSearchResult" class="d-none">
                        <td colspan="8" class="text-center text-muted py-4">
                            Transaksi tidak ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <span class="text-muted small">
                Menampilkan {{ $sales->count() }} transaksi
            </span>

            <a href="{{ route('dashboard') }}"
               class="btn btn-light btn-sm rounded-3">
                <i class="bi bi-arrow-left me-1"></i>
                Dashboard
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('searchTransaction');
    const rows = document.querySelectorAll('.transaction-row');
    const noResult = document.getElementById('noSearchResult');

    searchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        let visibleCount = 0;

        rows.forEach(row => {
            const match = row.textContent.toLowerCase().includes(keyword);

            row.classList.toggle('d-none', !match);

            if (match) visibleCount++;
        });

        noResult.classList.toggle('d-none', visibleCount > 0);
    });
</script>
@endpush
