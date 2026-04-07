@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Producten</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">Nieuw product</a>
</div>

<div class="table-responsive">
    <table class="table table-hover bg-white shadow-sm rounded">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Naam</th>
                <th>SKU</th>
                <th>EAN</th>
                <th>Type</th>
                <th>Kleur</th>
                <th>Prijs</th>
                <th>Voorraad</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td class="text-muted small">{{ $product->pick_order }}</td>
                <td><strong><a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">{{ $product->name }}</a></strong></td>
                <td><code>{{ $product->sku }}</code></td>
                <td>{{ $product->ean ?: '-' }}</td>
                <td>{{ $product->type ?: '-' }}</td>
                <td>{{ $product->color ?: '-' }}</td>
                <td>{{ $product->price !== null ? '€ ' . number_format($product->price, 2, ',', '.') : '-' }}</td>
                <td>
                    <span class="badge {{ $product->stock <= $product->minimum_stock ? 'bg-danger' : 'bg-success' }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td>{!! $product->is_active ? '<span class="badge bg-success">Actief</span>' : '<span class="badge bg-secondary">Inactief</span>' !!}</td>
                <td class="text-end">
                    <div class="d-flex gap-1 justify-content-end">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">Bewerk</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Weet je het zeker?')">Verwijder</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="10" class="text-muted text-center py-4">Geen producten gevonden.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection