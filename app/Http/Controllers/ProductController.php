<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        $products = Product::latest()->get();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['minimum_stock'] = $validated['minimum_stock'] ?? 0;

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product succesvol aangemaakt.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

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
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku,' . $product->id],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['minimum_stock'] = $validated['minimum_stock'] ?? 0;

        $product->update($validated);

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