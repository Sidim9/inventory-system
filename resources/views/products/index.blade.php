@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Producten</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">Nieuw product</a>
</div>

@forelse ($products as $product)
    <div class="card mb-2 border-0 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <span>
                <strong>{{ $product->name }}</strong> &mdash;
                SKU: {{ $product->sku }} &mdash;
                Voorraad: <span class="badge {{ $product->stock <= $product->minimum_stock ? 'bg-danger' : 'bg-success' }}">{{ $product->stock }}</span>
                &mdash; {{ $product->is_active ? '<span class="badge bg-success">Actief</span>' : '<span class="badge bg-secondary">Inactief</span>' }}
            </span>
            <div class="d-flex gap-2">
                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-secondary">Bekijk</a>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">Bewerk</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Weet je het zeker?')">Verwijder</button>
                </form>
            </div>
        </div>
    </div>
@empty
    <p class="text-muted">Geen producten gevonden.</p>
@endforelse
@endsection