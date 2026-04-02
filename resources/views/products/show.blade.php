@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <h1 class="mb-4">Product</h1>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Naam</dt><dd class="col-sm-8">{{ $product->name }}</dd>
                    <dt class="col-sm-4">SKU</dt><dd class="col-sm-8">{{ $product->sku }}</dd>
                    <dt class="col-sm-4">EAN</dt><dd class="col-sm-8">{{ $product->ean ?: '-' }}</dd>
                    <dt class="col-sm-4">Type</dt><dd class="col-sm-8">{{ $product->type ?: '-' }}</dd>
                    <dt class="col-sm-4">Kleur</dt><dd class="col-sm-8">{{ $product->color ?: '-' }}</dd>
                    <dt class="col-sm-4">Prijs</dt><dd class="col-sm-8">{{ $product->price !== null ? '€ ' . number_format($product->price, 2, ',', '.') : '-' }}</dd>
                    <dt class="col-sm-4">Voorraad</dt>
                    <dd class="col-sm-8">
                        <span class="badge {{ $product->stock <= $product->minimum_stock ? 'bg-danger' : 'bg-success' }}">
                            {{ $product->stock }}
                        </span>
                    </dd>
                    <dt class="col-sm-4">Minimum voorraad</dt><dd class="col-sm-8">{{ $product->minimum_stock }}</dd>
                    <dt class="col-sm-4">Pickvolgorde</dt><dd class="col-sm-8">{{ $product->pick_order }}</dd>
                    <dt class="col-sm-4">Actief</dt><dd class="col-sm-8">{!! $product->is_active ? '<span class="badge bg-success">Ja</span>' : '<span class="badge bg-secondary">Nee</span>' !!}</dd>
                </dl>
            </div>
        </div>
        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Bewerk</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Terug</a>
        </div>

        {{-- Stock movement log --}}
        <h5 class="mt-5 mb-3">Voorraadgeschiedenis</h5>
        @if ($product->stockMovements->isEmpty())
            <p class="text-muted">Geen bewegingen gevonden voor dit product.</p>
        @else
        <div class="card border-0 shadow-sm">
            <table class="table table-sm mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Type</th>
                        <th>Wijziging</th>
                        <th>Voor</th>
                        <th>Na</th>
                        <th>Order</th>
                        <th>Notitie</th>
                        <th>Datum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product->stockMovements as $movement)
                    @php
                        $typeColors = ['in' => 'success', 'out' => 'danger', 'adjustment' => 'warning'];
                    @endphp
                    <tr>
                        <td><span class="badge bg-{{ $typeColors[$movement->type] ?? 'secondary' }}">{{ $movement->type }}</span></td>
                        <td>{{ $movement->quantity_change > 0 ? '+' : '' }}{{ $movement->quantity_change }}</td>
                        <td>{{ $movement->stock_before }}</td>
                        <td>{{ $movement->stock_after }}</td>
                        <td>{{ $movement->order->order_number ?? '-' }}</td>
                        <td>{{ $movement->note ?: '-' }}</td>
                        <td>{{ $movement->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection