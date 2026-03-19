<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with(['order', 'product'])->latest()->get();

        return view('order_items.index', compact('orderItems'));
    }

    public function create()
    {
        $orders = Order::latest()->get();
        $products = Product::where('is_active', true)->get();

        return view('order_items.create', compact('orders', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id'     => ['required', 'exists:orders,id'],
            'product_id'   => ['nullable', 'exists:products,id'],
            'sku'          => ['required', 'string', 'max:255'],
            'product_name' => ['required', 'string', 'max:255'],
            'quantity'     => ['required', 'integer', 'min:1'],
        ]);

        OrderItem::create($validated);

        return redirect()
            ->route('order_items.index')
            ->with('success', 'Orderregel succesvol aangemaakt.');
    }

    public function show(string $id)
    {
        $orderItem = OrderItem::with(['order', 'product'])->findOrFail($id);

        return view('order_items.show', compact('orderItem'));
    }

    public function edit(string $id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orders = Order::latest()->get();
        $products = Product::where('is_active', true)->get();

        return view('order_items.edit', compact('orderItem', 'orders', 'products'));
    }

    public function update(Request $request, string $id)
    {
        $orderItem = OrderItem::findOrFail($id);

        $validated = $request->validate([
            'order_id'     => ['required', 'exists:orders,id'],
            'product_id'   => ['nullable', 'exists:products,id'],
            'sku'          => ['required', 'string', 'max:255'],
            'product_name' => ['required', 'string', 'max:255'],
            'quantity'     => ['required', 'integer', 'min:1'],
        ]);

        $orderItem->update($validated);

        return redirect()
            ->route('order_items.index')
            ->with('success', 'Orderregel succesvol bijgewerkt.');
    }

    public function destroy(string $id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();

        return redirect()
            ->route('order_items.index')
            ->with('success', 'Orderregel succesvol verwijderd.');
    }
}
