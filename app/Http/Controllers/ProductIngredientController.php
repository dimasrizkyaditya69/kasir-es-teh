<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Ingredient;
use App\Models\ProductIngredient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductIngredientController extends Controller
{
    public function index(Product $product)
    {
        $product->load('ingredients.ingredient');

        return view('product-ingredients.index', compact('product'));
    }

    public function create(Product $product)
    {
        $ingredients = Ingredient::orderBy('name')->get();

        return view('product-ingredients.create', compact(
            'product',
            'ingredients'
        ));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'ingredient_id' => [
                'required',
                'exists:ingredients,id',
                Rule::unique('product_ingredients', 'ingredient_id')
                    ->where('product_id', $product->id),
            ],
            'quantity' => ['required', 'numeric', 'gt:0'],
        ], [
            'ingredient_id.unique' => 'Bahan baku ini sudah ada dalam resep produk.',
        ]);

        $product->ingredients()->create($validated);

        return redirect()
            ->route('product-ingredients.index', $product)
            ->with('success', 'Bahan baku berhasil ditambahkan ke resep.');
    }

    public function edit(ProductIngredient $productIngredient)
    {
        $productIngredient->load('product', 'ingredient');

        return view('product-ingredients.edit', compact('productIngredient'));
    }

    public function update(Request $request, ProductIngredient $productIngredient)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'numeric', 'gt:0'],
        ]);

        $productIngredient->update($validated);

        return redirect()
            ->route('product-ingredients.index', $productIngredient->product_id)
            ->with('success', 'Komposisi bahan baku berhasil diperbarui.');
    }

    public function destroy(ProductIngredient $productIngredient)
    {
        $productId = $productIngredient->product_id;

        $productIngredient->delete();

        return redirect()
            ->route('product-ingredients.index', $productId)
            ->with('success', 'Bahan baku berhasil dihapus dari resep.');
    }
}
