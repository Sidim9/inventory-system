<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PicklistController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)
            ->orderBy('pick_order')
            ->orderBy('name')
            ->get();

        return view('picklist.index', compact('products'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'pick_order'   => ['required', 'array'],
            'pick_order.*' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($request->input('pick_order') as $productId => $order) {
            Product::where('id', $productId)->update(['pick_order' => $order]);
        }

        return redirect()
            ->route('picklist.index')
            ->with('success', 'Picklijst volgorde opgeslagen.');
    }
}
