@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Voorraadbewegingen</h1>
    <a href="{{ route('stock_movements.create') }}" class="btn btn-primary">Nieuwe beweging</a>
</div>

<div class="card border-0 shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th>Product</th>
                <th>SKU</th>
                <th>Huidige voorraad</th>
                <th>Totaal ingekomen</th>
                <th>Totaal uitgegaan</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td>
                    <a href="{{ route('products.show', $product->id) }}" class="fw-semibold text-decoration-none">
                        {{ $product->name }}
                    </a>
                </td>
                <td><code>{{ $product->sku }}</code></td>
                <td>
                    <span class="badge {{ $product->stock <= $product->minimum_stock ? 'bg-danger' : 'bg-success' }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td><span class="text-success fw-semibold">+{{ $product->total_in }}</span></td>
                <td><span class="text-danger fw-semibold">-{{ $product->total_out }}</span></td>
                <td class="text-end">
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-secondary">Bekijk bewegingen</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-muted text-center py-4">Geen voorraadbewegingen gevonden.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
