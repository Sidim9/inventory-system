<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\StockMovement;
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
        $orders   = Order::latest()->get();
        $products = Product::where('is_active', true)->orderBy('pick_order')->orderBy('name')->get();

        return view('order_items.create', compact('orders', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id'=> ['required', 'exists:orders,id'],
            'product_id'=> ['nullable', 'exists:products,id'],
            'ean'=> ['nullable', 'string', 'max:255'],
            'sku'=> ['nullable', 'string', 'max:255'],
            'product_name'=> ['required', 'string', 'max:255'],
            'quantity'=> ['required', 'integer', 'min:1'],
            'unit_price'   => ['nullable', 'numeric', 'min:0'],
        ]);

        // Auto-fill snapshot data from product if product is selected
        if (!empty($validated['product_id'])) {
            $product = Product::find($validated['product_id']);
            if ($product) {
                $validated['ean']= $validated['ean']?: $product->ean;
                $validated['sku']= $validated['sku']?: $product->sku;
                $validated['product_name']= $validated['product_name'] ?: $product->name;
                $validated['unit_price']= $validated['unit_price'] ?? $product->price;

                // Deduct stock and log movement
                $stockBefore = $product->stock;
                $stockAfter  = $stockBefore - $validated['quantity'];

                StockMovement::create([
                    'product_id'=> $product->id,
                    'order_id'=> $validated['order_id'],
                    'type'=> 'out',
                    'quantity_change'=> -$validated['quantity'],
                    'stock_before'=> $stockBefore,
                    'stock_after'=> $stockAfter,
                    'note'=> 'Automatisch bij aanmaken orderregel',
                ]);

                $product->update(['stock' => $stockAfter]);
            }
        }

        OrderItem::create($validated);

        return redirect()
            ->route('orders.show', $validated['order_id'])
            ->with('success', 'Product toegevoegd aan order.');
    }

    public function show(string $id)
    {
        $orderItem = OrderItem::with(['order', 'product'])->findOrFail($id);

        return view('order_items.show', compact('orderItem'));
    }

    public function edit(string $id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orders    = Order::latest()->get();
        $products  = Product::where('is_active', true)->orderBy('pick_order')->orderBy('name')->get();

        return view('order_items.edit', compact('orderItem', 'orders', 'products'));
    }

    public function update(Request $request, string $id)
    {
        $orderItem = OrderItem::findOrFail($id);

        $validated = $request->validate([
            'order_id'    => ['required', 'exists:orders,id'],
            'product_id'  => ['nullable', 'exists:products,id'],
            'ean'         => ['nullable', 'string', 'max:255'],
            'sku'         => ['nullable', 'string', 'max:255'],
            'product_name'=> ['required', 'string', 'max:255'],
            'quantity'    => ['required', 'integer', 'min:1'],
            'unit_price'  => ['nullable', 'numeric', 'min:0'],
        ]);

        $oldProductId  = $orderItem->product_id;
        $newProductId  = $validated['product_id'] ?? null;
        $oldQuantity   = $orderItem->quantity;
        $newQuantity   = $validated['quantity'];

        // Return stock to the old product
        if ($oldProductId) {
            $oldProduct  = Product::find($oldProductId);
            if ($oldProduct) {
                $stockBefore = $oldProduct->stock;
                $stockAfter  = $stockBefore + $oldQuantity;
                StockMovement::create([
                    'product_id'     => $oldProduct->id,
                    'order_id'       => $oldProductId == $newProductId ? $validated['order_id'] : $orderItem->order_id,
                    'type'           => 'in',
                    'quantity_change' => $oldQuantity,
                    'stock_before'   => $stockBefore,
                    'stock_after'    => $stockAfter,
                    'note'           => 'Terugboeking bij bewerken orderregel',
                ]);
                $oldProduct->update(['stock' => $stockAfter]);
            }
        }

        // Deduct stock from the new product
        if ($newProductId) {
            $newProduct = Product::find($newProductId);
            if ($newProduct) {
                $stockBefore = $newProduct->stock;
                $stockAfter  = $stockBefore - $newQuantity;
                StockMovement::create([
                    'product_id'     => $newProduct->id,
                    'order_id'       => $validated['order_id'],
                    'type'           => 'out',
                    'quantity_change' => -$newQuantity,
                    'stock_before'   => $stockBefore,
                    'stock_after'    => $stockAfter,
                    'note'           => 'Automatisch bij bewerken orderregel',
                ]);
                $newProduct->update(['stock' => $stockAfter]);
            }
        }

        $orderItem->update($validated);

        return redirect()
            ->route('orders.show', $orderItem->order_id)
            ->with('success', 'Orderregel succesvol bijgewerkt.');
    }

    public function destroy(string $id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderId   = $orderItem->order_id;

        // Return stock when a linked order item is removed
        if ($orderItem->product_id) {
            $product = Product::find($orderItem->product_id);
            if ($product) {
                $stockBefore = $product->stock;
                $stockAfter  = $stockBefore + $orderItem->quantity;
                StockMovement::create([
                    'product_id'     => $product->id,
                    'order_id'       => $orderId,
                    'type'           => 'in',
                    'quantity_change' => $orderItem->quantity,
                    'stock_before'   => $stockBefore,
                    'stock_after'    => $stockAfter,
                    'note'           => 'Terugboeking bij verwijderen orderregel',
                ]);
                $product->update(['stock' => $stockAfter]);
            }
        }

        $orderItem->delete();

        return redirect()
            ->route('orders.show', $orderId)
            ->with('success', 'Orderregel verwijderd.');
    }
}

