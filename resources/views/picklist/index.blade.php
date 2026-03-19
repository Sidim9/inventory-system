@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1>Picklijst</h1>
        <p class="text-muted mb-0">Stel de volgorde in waarop producten gepickt worden. Lagere nummers worden eerst gepickt.</p>
    </div>
</div>

@if ($products->isEmpty())
    <p class="text-muted">Geen actieve producten gevonden.</p>
@else
<form action="{{ route('picklist.save') }}" method="POST">
    @csrf
    <div class="table-responsive">
        <table class="table table-hover bg-white shadow-sm rounded">
            <thead class="table-light">
                <tr>
                    <th style="width:100px">Volgorde</th>
                    <th>EAN</th>
                    <th>SKU</th>
                    <th>Naam</th>
                    <th>Type</th>
                    <th>Kleur</th>
                    <th class="text-center">Voorraad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>
                        <input type="number"
                               name="pick_order[{{ $product->id }}]"
                               class="form-control form-control-sm"
                               value="{{ $product->pick_order }}"
                               min="0"
                               style="width:80px">
                    </td>
                    <td>{{ $product->ean ?: '-' }}</td>
                    <td><code>{{ $product->sku }}</code></td>
                    <td><strong>{{ $product->name }}</strong></td>
                    <td>{{ $product->type ?: '-' }}</td>
                    <td>{{ $product->color ?: '-' }}</td>
                    <td class="text-center">
                        <span class="badge {{ $product->stock <= $product->minimum_stock ? 'bg-danger' : 'bg-success' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <button type="submit" class="btn btn-primary">Volgorde opslaan</button>
    <a href="{{ route('picklist.index') }}" class="btn btn-secondary ms-1">Annuleren</a>
</form>
@endif
@endsection
