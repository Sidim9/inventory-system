<?php

namespace App\Http\Controllers;

use App\Models\OrderAddress;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderAddressController extends Controller
{
    public function index()
    {
        $orderAddresses = OrderAddress::with('orders')->latest()->get();

        return view('order_addresses.index', compact('orderAddresses'));
    }

    public function create()
    {
        $orders = Order::latest()->get();

        return view('order_addresses.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id'=> ['required', 'exists:orders,id'],
            'type'=> ['required', 'string', 'max:50'],
            'first_name'=> ['nullable', 'string', 'max:255'],
            'last_name'=> ['nullable', 'string', 'max:255'],
            'company'=> ['nullable', 'string', 'max:255'],
            'street'=> ['nullable', 'string', 'max:255'],
            'house_number'=> ['nullable', 'string', 'max:20'],
            'house_number_addition'=> ['nullable', 'string', 'max:20'],
            'postal_code'=> ['nullable', 'string', 'max:20'],
            'city'=> ['nullable', 'string', 'max:255'],
            'state'=> ['nullable', 'string', 'max:255'],
            'country'=> ['nullable', 'string', 'max:255'],
            'phone'=> ['nullable', 'string', 'max:50'],
        ]);

        OrderAddress::create($validated);

        return redirect()
            ->route('order_addresses.index')
            ->with('success', 'Orderadres succesvol aangemaakt.');
    }

    public function show(string $id)
    {
        $orderAddress = OrderAddress::with('orders')->findOrFail($id);

        return view('order_addresses.show', compact('orderAddress'));
    }

    public function edit(string $id)
    {
        $orderAddress = OrderAddress::findOrFail($id);
        $orders = Order::latest()->get();

        return view('order_addresses.edit', compact('orderAddress', 'orders'));
    }

    public function update(Request $request, string $id)
    {
        $orderAddress = OrderAddress::findOrFail($id);

        $validated = $request->validate([
            'order_id'=> ['required', 'exists:orders,id'],
            'type'=> ['required', 'string', 'max:50'],
            'first_name'=> ['nullable', 'string', 'max:255'],
            'last_name'=> ['nullable', 'string', 'max:255'],
            'company'=> ['nullable', 'string', 'max:255'],
            'street'=> ['nullable', 'string', 'max:255'],
            'house_number'=> ['nullable', 'string', 'max:20'],
            'house_number_addition'=> ['nullable', 'string', 'max:20'],
            'postal_code'=> ['nullable', 'string', 'max:20'],
            'city'=> ['nullable', 'string', 'max:255'],
            'state'=> ['nullable', 'string', 'max:255'],
            'country'=> ['nullable', 'string', 'max:255'],
            'phone'=> ['nullable', 'string', 'max:50'],
        ]);

        $orderAddress->update($validated);

        return redirect()
            ->route('order_addresses.index')
            ->with('success', 'Orderadres succesvol bijgewerkt.');
    }

    public function destroy(string $id)
    {
        $orderAddress = OrderAddress::findOrFail($id);
        $orderAddress->delete();

        return redirect()
            ->route('order_addresses.index')
            ->with('success', 'Orderadres succesvol verwijderd.');
    }
}
