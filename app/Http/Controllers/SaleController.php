<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('user')
            ->latest()
            ->get();

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::with('category')
            ->where('is_available', true)
            ->orderBy('name')
            ->get();

        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => ['required', 'array'],
            'items.*.product_id' => [
                'required',
                'integer',
                'distinct',
                'exists:products,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:0',
            ],
            'paid_amount' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $items = collect($validated['items'])
            ->filter(fn ($item) => (int) $item['quantity'] > 0);

        if ($items->isEmpty()) {
            throw ValidationException::withMessages([
                'items' => 'Pilih minimal satu produk.',
            ]);
        }

        $sale = DB::transaction(function () use ($items, $validated) {

            $productIds = $items->pluck('product_id')->all();

            $products = Product::with('ingredients.ingredient')
                ->whereIn('id', $productIds)
                ->get()
                ->keyBy('id');

            $totalAmount = 0;
            $requirements = [];

            foreach ($items as $item) {
                $product = $products->get($item['product_id']);

                if (!$product || !$product->is_available) {
                    throw ValidationException::withMessages([
                        'items' => 'Ada produk yang tidak tersedia.',
                    ]);
                }

                $quantity = (int) $item['quantity'];
                $price = (float) $product->price;

                $totalAmount += $price * $quantity;

                foreach ($product->ingredients as $recipe) {
                    $ingredientId = $recipe->ingredient_id;

                    $requirements[$ingredientId] =
                        ($requirements[$ingredientId] ?? 0)
                        + ((float) $recipe->quantity * $quantity);
                }
            }

            $paidAmount = (float) $validated['paid_amount'];

            if ($paidAmount < $totalAmount) {
                throw ValidationException::withMessages([
                    'paid_amount' => 'Uang pembayaran kurang dari total transaksi.',
                ]);
            }

            // Kunci stok bahan baku secara berurutan.
            $ingredients = Ingredient::whereIn(
                'id',
                array_keys($requirements)
            )
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Periksa seluruh kebutuhan stok sebelum mengurangi.
            foreach ($requirements as $ingredientId => $required) {
                $ingredient = $ingredients->get($ingredientId);

                if (!$ingredient || (float) $ingredient->stock < $required) {
                    $name = $ingredient?->name ?? 'Bahan baku';

                    throw ValidationException::withMessages([
                        'items' => "Stok {$name} tidak mencukupi.",
                    ]);
                }
            }

            $invoiceNumber = 'INV-' . now()->format('YmdHis')
                . '-' . Str::upper(Str::random(5));

            $sale = Sale::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'change_amount' => $paidAmount - $totalAmount,
                'status' => 'completed',
            ]);

            // Simpan detail transaksi.
            foreach ($items as $item) {
                $product = $products->get($item['product_id']);
                $quantity = (int) $item['quantity'];
                $price = (float) $product->price;

                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $price * $quantity,
                ]);
            }

            // Kurangi stok dan catat riwayat pemakaian.
            foreach ($requirements as $ingredientId => $required) {
                $ingredient = $ingredients->get($ingredientId);

                $ingredient->decrement('stock', $required);

                StockMovement::create([
                    'ingredient_id' => $ingredientId,
                    'type' => 'out',
                    'quantity' => $required,
                    'description' => "Pemakaian bahan untuk transaksi {$invoiceNumber}",
                ]);
            }

            return $sale;
        });

        return redirect()
            ->route('sales.index')
            ->with('success', 'Transaksi berhasil disimpan. Invoice: ' . $sale->invoice_number);
    }
}
