<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with('ingredient')
            ->latest()
            ->get();

        return view('stock-movements.index', compact('movements'));
    }

    public function create()
    {
        $ingredients = Ingredient::orderBy('name')->get();

        return view('stock-movements.create', compact('ingredients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ingredient_id' => ['required', 'exists:ingredients,id'],
            'type' => ['required', Rule::in(['in', 'out'])],
            'quantity' => ['required', 'numeric', 'gt:0'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($validated) {
            $ingredient = Ingredient::whereKey($validated['ingredient_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $quantity = (float) $validated['quantity'];
            $currentStock = (float) $ingredient->stock;

            if ($validated['type'] === 'out' && $quantity > $currentStock) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'quantity' => 'Stok tidak mencukupi. Stok tersedia: ' . $currentStock,
                ]);
            }

            if ($validated['type'] === 'in') {
                $ingredient->increment('stock', $quantity);
            } else {
                $ingredient->decrement('stock', $quantity);
            }

            StockMovement::create([
                'ingredient_id' => $ingredient->id,
                'type' => $validated['type'],
                'quantity' => $quantity,
                'description' => $validated['description'] ?? null,
            ]);
        });

        return redirect()
            ->route('stock-movements.index')
            ->with('success', 'Perubahan stok berhasil dicatat.');
    }
}
