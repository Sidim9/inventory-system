<?php

namespace App\Http\Controllers;

use App\Models\Marketplace;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index()
    {
        $marketplaces = Marketplace::latest()->get();

        return view('marketplaces.index', compact('marketplaces'));
    }

    public function create()
    {
        return view('marketplaces.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:marketplaces,code'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        Marketplace::create($validated);

        return redirect()
            ->route('marketplaces.index')
            ->with('success', 'Marketplace succesvol aangemaakt.');
    }

    public function show(string $id)
    {
        $marketplace = Marketplace::findOrFail($id);

        return view('marketplaces.show', compact('marketplace'));
    }

    public function edit(string $id)
    {
        $marketplace = Marketplace::findOrFail($id);

        return view('marketplaces.edit', compact('marketplace'));
    }

    public function update(Request $request, string $id)
    {
        $marketplace = Marketplace::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:marketplaces,code,' . $marketplace->id],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        $marketplace->update($validated);

        return redirect()
            ->route('marketplaces.index')
            ->with('success', 'Marketplace succesvol bijgewerkt.');
    }

    public function destroy(string $id)
    {
        $marketplace = Marketplace::findOrFail($id);
        $marketplace->delete();

        return redirect()
            ->route('marketplaces.index')
            ->with('success', 'Marketplace succesvol verwijderd.');
    }
}