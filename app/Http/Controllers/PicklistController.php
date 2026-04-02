<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Picklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PicklistController extends Controller
{
    public function index()
    {
        $picklists = Picklist::withCount('orders')
            ->latest()
            ->get();

        return view('picklists.index', compact('picklists'));
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'order_ids'   => ['required', 'array', 'min:1'],
            'order_ids.*' => ['integer', 'exists:orders,id'],
        ]);

        // Only process orders that are still unassigned (active)
        $orders = Order::with('items')
            ->whereNull('picklist_id')
            ->whereIn('id', $validated['order_ids'])
            ->get();

        if ($orders->isEmpty()) {
            return back()->with('error', 'Geen actieve orders geselecteerd.');
        }

        $totalItems     = $orders->sum(fn (Order $order) => $order->items->sum('quantity'));
        $today          = now()->toDateString();
        $sequenceNumber = Picklist::whereDate('created_at', $today)->count() + 1;

        $name = sprintf('%s-L%d-%dst', $today, $sequenceNumber, $totalItems);

        $picklist = DB::transaction(function () use ($name, $totalItems, $orders) {
            $picklist = Picklist::create([
                'name'        => $name,
                'total_items' => $totalItems,
            ]);

            Order::whereIn('id', $orders->pluck('id'))->update([
                'picklist_id' => $picklist->id,
            ]);

            return $picklist;
        });

        return redirect()
            ->route('picklists.show', $picklist)
            ->with('success', "Picklijst \"{$picklist->name}\" aangemaakt met {$orders->count()} order(s).");
    }

    public function show(Picklist $picklist)
    {
        $picklist->load(['orders.items.product']);

        return view('picklists.show', compact('picklist'));
    }
}
