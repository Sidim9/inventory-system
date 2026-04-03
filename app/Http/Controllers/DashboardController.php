<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Picklist;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders        = Order::whereNull('picklist_id')->count();
        $totalPicklists     = Picklist::count();
        $totalSoldItems     = OrderItem::sum('quantity');
        $lowStockProducts   = Product::where('is_active', true)
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->get();
        $latestOrders       = Order::whereNull('picklist_id')
            ->latest('ordered_at')
            ->limit(50)
            ->get();

        return view('welcome', compact(
            'totalOrders',
            'totalPicklists',
            'totalSoldItems',
            'lowStockProducts',
            'latestOrders'
        ));
    }
}
