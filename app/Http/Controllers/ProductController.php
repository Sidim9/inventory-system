<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderByRaw('pick_order IS NULL, pick_order')->orderBy('name')->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=> ['required', 'string', 'max:255'],
            'sku'=> ['required', 'string', 'max:255', 'unique:products,sku'],
            'ean'=> ['nullable', 'string', 'max:255', 'unique:products,ean'],
            'type'=> ['nullable', 'string', 'max:255'],
            'color'=> ['nullable', 'string', 'max:255'],
            'price'=> ['nullable', 'numeric', 'min:0'],
            'stock'=> ['required', 'integer', 'min:0'],
            'minimum_stock'=> ['nullable', 'integer', 'min:0'],
            'pick_order'=> ['nullable', 'integer', 'min:1', 'unique:products,pick_order'],
            'is_active'=> ['nullable', 'boolean'],
        ]);

        $validated['is_active']= $request->has('is_active');
        $validated['minimum_stock']= $validated['minimum_stock'] ?? 0;
        $validated['pick_order']= $validated['pick_order'] ?? null;

        $product = Product::create($validated);

        // Log initial stock as an incoming stock movement
        if ($product->stock > 0) {
            StockMovement::create([
                'product_id'=> $product->id,
                'order_id'=> null,
                'type'=> 'in',
                'quantity_change'=> $product->stock,
                'stock_before'=> 0,
                'stock_after'=> $product->stock,
                'note'            => 'Initiële voorraad',
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product succesvol aangemaakt.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['stockMovements' => fn($q) => $q->latest()])->findOrFail($id);

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name'=> ['required', 'string', 'max:255'],
            'sku'=> ['required', 'string', 'max:255', 'unique:products,sku,' . $product->id],
            'ean'=> ['nullable', 'string', 'max:255', 'unique:products,ean,' . $product->id],
            'type'=> ['nullable', 'string', 'max:255'],
            'color'=> ['nullable', 'string', 'max:255'],
            'price'=> ['nullable', 'numeric', 'min:0'],
            'stock'=> ['required', 'integer', 'min:0'],
            'minimum_stock'=> ['nullable', 'integer', 'min:0'],
            'pick_order'=> ['nullable', 'integer', 'min:1', 'unique:products,pick_order,' . $product->id],
            'is_active'=> ['nullable', 'boolean'],
        ]);

        $validated['is_active']= $request->has('is_active');
        $validated['minimum_stock']= $validated['minimum_stock'] ?? 0;
        $validated['pick_order']= $validated['pick_order'] ?? null;

        $stockBefore = $product->stock;

        $product->update($validated);

        // Log stock change if the stock value was manually adjusted
        $stockAfter = (int) $validated['stock'];
        if ($stockAfter !== $stockBefore) {
            $diff = $stockAfter - $stockBefore;
            StockMovement::create([
                'product_id'=> $product->id,
                'order_id'=> null,
                'type'=> $diff > 0 ? 'in' : 'out',
                'quantity_change'=> $diff,
                'stock_before'=> $stockBefore,
                'stock_after'=> $stockAfter,
                'note'=> 'Handmatige voorraadaanpassing',
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product succesvol bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product succesvol verwijderd.');
    }
}