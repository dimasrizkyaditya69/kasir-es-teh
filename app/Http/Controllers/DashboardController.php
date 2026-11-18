<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Ingredient;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        // Statistik penjualan hari ini
        $totalSales = Sale::whereDate('created_at', $today)->count();

        $totalRevenue = Sale::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('total_amount');

        // Jumlah produk tersedia
        $totalProducts = Product::where('is_available', true)->count();

        // Bahan baku dengan stok menipis
        $lowStockIngredients = Ingredient::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();

        // Transaksi terbaru
        $recentSales = Sale::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Grafik penjualan 7 hari terakhir
        $salesChart = Sale::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->where('status', 'completed')
            ->whereDate('created_at', '>=', now()->subDays(6)->toDateString())
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $chartLabels = [];
        $chartValues = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();

            $chartLabels[] = now()->subDays($i)->format('d/m');

            $chartValues[] = (float) ($salesChart[$date]->total ?? 0);
        }

        return view('dashboard', compact(
            'totalSales',
            'totalRevenue',
            'totalProducts',
            'lowStockIngredients',
            'recentSales',
            'chartLabels',
            'chartValues'
        ));
    }
}
