<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::whereNull('picklist_id')
            ->withCount('items')
            ->latest('ordered_at')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $suggestedOrderNumber = Order::generateOrderNumber();

        return view('orders.create', compact('suggestedOrderNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_number'=> ['nullable', 'string', 'max:255', 'unique:orders,order_number'],
            'source'=> ['nullable', 'string', 'max:255'],
            'customer_name'=> ['nullable', 'string', 'max:255'],
            'customer_email'=> ['nullable', 'email', 'max:255'],
            'company_name'=> ['nullable', 'string', 'max:255'],
            'phone'=> ['nullable', 'string', 'max:50'],
            'street'=> ['nullable', 'string', 'max:255'],
            'house_number'=> ['nullable', 'string', 'max:20'],
            'house_number_addition'=> ['nullable', 'string', 'max:20'],
            'postal_code'=> ['nullable', 'string', 'max:20'],
            'city'=> ['nullable', 'string', 'max:255'],
            'country'=> ['nullable', 'string', 'max:10'],
            'notes'=> ['nullable', 'string'],
            'ordered_at'=> ['nullable', 'date'],
        ]);

        $validated['status']       = OrderStatus::Pending->value;
        $validated['ordered_at']   = $validated['ordered_at'] ?? now();
        $validated['order_number']  = $validated['order_number'] ?: Order::generateOrderNumber();

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
            'order_number'=> ['required', 'string', 'max:255', 'unique:orders,order_number,' . $order->id],
            'source'=> ['nullable', 'string', 'max:255'],
            'customer_name'=> ['nullable', 'string', 'max:255'],
            'customer_email'=> ['nullable', 'email', 'max:255'],
            'company_name'=> ['nullable', 'string', 'max:255'],
            'phone'=> ['nullable', 'string', 'max:50'],
            'street'=> ['nullable', 'string', 'max:255'],
            'house_number'=> ['nullable', 'string', 'max:20'],
            'house_number_addition'=> ['nullable', 'string', 'max:20'],
            'postal_code'=> ['nullable', 'string', 'max:20'],
            'city'=> ['nullable', 'string', 'max:255'],
            'country'=> ['nullable', 'string', 'max:10'],
            'status'=> ['required', new Enum(OrderStatus::class)],
            'notes'=> ['nullable', 'string'],
            'ordered_at'=> ['nullable', 'date'],
        ]);

        $order->update($validated);

        return redirect()
            ->route('orders.show', $order->id)
            ->with('success', 'Order succesvol bijgewerkt.');
    }

    public function receive(Order $order)
    {
        $order->update(['status' => OrderStatus::Received->value]);

        // Mark the picklist as fully processed when all its orders are received
        if ($order->picklist_id) {
            $picklist = $order->picklist;
            $allReceived = $picklist->orders()
                ->where('status', '!=', OrderStatus::Received->value)
                ->doesntExist();

            if ($allReceived) {
                $picklist->update(['processed_at' => now()]);
            }
        }

        return back()->with('success', "Order {$order->order_number} gemarkeerd als ontvangen.");
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
