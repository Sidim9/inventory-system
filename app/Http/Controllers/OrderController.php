<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest('ordered_at')->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_number'           => ['required', 'string', 'max:255', 'unique:orders,order_number'],
            'source'                 => ['nullable', 'string', 'max:255'],
            'customer_name'          => ['nullable', 'string', 'max:255'],
            'customer_email'         => ['nullable', 'email', 'max:255'],
            'phone'                  => ['nullable', 'string', 'max:50'],
            'street'                 => ['nullable', 'string', 'max:255'],
            'house_number'           => ['nullable', 'string', 'max:20'],
            'house_number_addition'  => ['nullable', 'string', 'max:20'],
            'postal_code'            => ['nullable', 'string', 'max:20'],
            'city'                   => ['nullable', 'string', 'max:255'],
            'country'                => ['nullable', 'string', 'max:10'],
            'status'                 => ['required', 'string', 'max:50'],
            'notes'                  => ['nullable', 'string'],
            'ordered_at'             => ['nullable', 'date'],
        ]);

        $validated['ordered_at'] = $validated['ordered_at'] ?? now();

        $order = Order::create($validated);

        return redirect()
            ->route('orders.show', $order->id)
            ->with('success', 'Order succesvol aangemaakt. Voeg nu producten toe.');
    }

    public function show(string $id)
    {
        $order = Order::with(['items.product', 'stockMovements.product'])->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function edit(string $id)
    {
        $order = Order::findOrFail($id);

        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'order_number'           => ['required', 'string', 'max:255', 'unique:orders,order_number,' . $order->id],
            'source'                 => ['nullable', 'string', 'max:255'],
            'customer_name'          => ['nullable', 'string', 'max:255'],
            'customer_email'         => ['nullable', 'email', 'max:255'],
            'phone'                  => ['nullable', 'string', 'max:50'],
            'street'                 => ['nullable', 'string', 'max:255'],
            'house_number'           => ['nullable', 'string', 'max:20'],
            'house_number_addition'  => ['nullable', 'string', 'max:20'],
            'postal_code'            => ['nullable', 'string', 'max:20'],
            'city'                   => ['nullable', 'string', 'max:255'],
            'country'                => ['nullable', 'string', 'max:10'],
            'status'                 => ['required', 'string', 'max:50'],
            'notes'                  => ['nullable', 'string'],
            'ordered_at'             => ['nullable', 'date'],
        ]);

        $order->update($validated);

        return redirect()
            ->route('orders.show', $order->id)
            ->with('success', 'Order succesvol bijgewerkt.');
    }

    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order verwijderd.');
    }
}
