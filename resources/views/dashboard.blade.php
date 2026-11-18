@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold mb-1">Dashboard</h3>
    <p class="text-muted mb-0">
        Selamat datang kembali, {{ auth()->user()->name }}!
    </p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-2">Pendapatan Hari Ini</p>
                        <h4 class="fw-bold mb-0">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </h4>
                    </div>
                    <i class="bi bi-cash-stack fs-2 text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-2">Transaksi Hari Ini</p>
                        <h4 class="fw-bold mb-0">{{ $totalSales }}</h4>
                    </div>
                    <i class="bi bi-receipt fs-2 text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-2">Produk Tersedia</p>
                        <h4 class="fw-bold mb-0">{{ $totalProducts }}</h4>
                    </div>
                    <i class="bi bi-cup-straw fs-2 text-warning"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-2">Stok Menipis</p>
                        <h4 class="fw-bold mb-0">{{ $lowStockIngredients }}</h4>
                    </div>
                    <i class="bi bi-exclamation-triangle fs-2 text-danger"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="mb-3">
                    <h5 class="fw-bold mb-1">Ringkasan Penjualan</h5>
                    <p class="text-muted small mb-0">Pendapatan selama 7 hari terakhir</p>
                </div>

                <div style="height: 300px;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Akses Cepat</h5>

                <div class="d-grid gap-2">
                    <a href="{{ route('sales.create') }}"
                       class="btn btn-success rounded-3 py-2">
                        <i class="bi bi-cart-plus me-2"></i>
                        Transaksi Baru
                    </a>

                    <a href="{{ route('products.index') }}"
                       class="btn btn-outline-success rounded-3 py-2">
                        <i class="bi bi-cup-straw me-2"></i>
                        Kelola Produk
                    </a>

                    <a href="{{ route('ingredients.index') }}"
                       class="btn btn-outline-success rounded-3 py-2">
                        <i class="bi bi-box-seam me-2"></i>
                        Kelola Bahan Baku
                    </a>

                    <a href="{{ route('sales.index') }}"
                       class="btn btn-outline-success rounded-3 py-2">
                        <i class="bi bi-clock-history me-2"></i>
                        Riwayat Transaksi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mt-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-1">Transaksi Terbaru</h5>
                <p class="text-muted small mb-0">5 transaksi terakhir</p>
            </div>

            <a href="{{ route('sales.index') }}"
               class="btn btn-sm btn-outline-success rounded-3">
                Lihat Semua
            </a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted small">
                        <th>Invoice</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentSales as $sale)
                        <tr>
                            <td class="fw-semibold">{{ $sale->invoice_number }}</td>
                            <td>{{ $sale->user->name ?? '-' }}</td>
                            <td>
                                Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </td>
                            <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartLabels = @json($chartLabels);
    const chartValues = @json($chartValues);

    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Pendapatan',
                data: chartValues,
                borderColor: '#1D604B',
                backgroundColor: 'rgba(29, 96, 75, 0.10)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 4,
                pointBackgroundColor: '#1D604B'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => 'Rp ' + value.toLocaleString('id-ID')
                    }
                }
            }
        }
    });
</script>
@endpush