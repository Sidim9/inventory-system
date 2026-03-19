<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Marketplace;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('marketplace')->latest()->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $marketplaces = Marketplace::all();

        return view('orders.create', compact('marketplaces'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'marketplace_id' => ['nullable', 'exists:marketplaces,id'],
            'order_number' => ['required'],
            'external_order_id' => ['nullable'],
            'customer_name' => ['nullable'],
            'customer_email' => ['nullable', 'email'],
            'status' => ['required'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        Order::create($validated);

        return redirect()->route('orders.index')
            ->with('success', 'Order aangemaakt');
    }

    public function show(string $id)
    {
        $order = Order::with('marketplace')->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function edit(string $id)
    {
        $order = Order::findOrFail($id);
        $marketplaces = Marketplace::all();

        return view('orders.edit', compact('order', 'marketplaces'));
    }

    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'marketplace_id' => ['nullable', 'exists:marketplaces,id'],
            'order_number' => ['required'],
            'external_order_id' => ['nullable'],
            'customer_name' => ['nullable'],
            'customer_email' => ['nullable', 'email'],
            'status' => ['required'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $order->update($validated);

        return redirect()->route('orders.index')
            ->with('success', 'Order geüpdatet');
    }

    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order verwijderd');
    }
}