<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        $stockMovements = StockMovement::with(['product', 'order'])->latest()->get();

        return view('stock_movements.index', compact('stockMovements'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->get();
        $orders = Order::latest()->get();

        return view('stock_movements.create', compact('products', 'orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'=> ['required', 'exists:products,id'],
            'order_id'=> ['nullable', 'exists:orders,id'],
            'type'=> ['required', 'in:in,out,adjustment'],
            'quantity_change'=> ['required', 'integer'],
            'note'=> ['nullable', 'string', 'max:500'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        $validated['stock_before'] = $product->stock;
        $validated['stock_after']  = $product->stock + $validated['quantity_change'];

        StockMovement::create($validated);

        $product->update(['stock' => $validated['stock_after']]);

        return redirect()
            ->route('stock_movements.index')
            ->with('success', 'Voorraadbeweging succesvol aangemaakt.');
    }

    public function show(string $id)
    {
        $stockMovement = StockMovement::with(['product', 'order'])->findOrFail($id);

        return view('stock_movements.show', compact('stockMovement'));
    }

    public function edit(string $id)
    {
        $stockMovement = StockMovement::findOrFail($id);
        $products = Product::where('is_active', true)->get();
        $orders = Order::latest()->get();

        return view('stock_movements.edit', compact('stockMovement', 'products', 'orders'));
    }

    public function update(Request $request, string $id)
    {
        $stockMovement = StockMovement::findOrFail($id);

        $validated = $request->validate([
            'product_id'=> ['required', 'exists:products,id'],
            'order_id'=> ['nullable', 'exists:orders,id'],
            'type'=> ['required', 'in:in,out,adjustment'],
            'quantity_change'=> ['required', 'integer'],
            'note'=> ['nullable', 'string', 'max:500'],
        ]);

        $stockMovement->update($validated);

        return redirect()
            ->route('stock_movements.index')
            ->with('success', 'Voorraadbeweging succesvol bijgewerkt.');
    }

    public function destroy(string $id)
    {
        $stockMovement = StockMovement::findOrFail($id);
        $stockMovement->delete();

        return redirect()
            ->route('stock_movements.index')
            ->with('success', 'Voorraadbeweging succesvol verwijderd.');
    }
}
