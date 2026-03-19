@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="mb-4">Product</h1>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Naam</dt><dd class="col-sm-8">{{ $product->name }}</dd>
                    <dt class="col-sm-4">SKU</dt><dd class="col-sm-8">{{ $product->sku }}</dd>
                    <dt class="col-sm-4">Voorraad</dt><dd class="col-sm-8">{{ $product->stock }}</dd>
                    <dt class="col-sm-4">Minimum voorraad</dt><dd class="col-sm-8">{{ $product->minimum_stock }}</dd>
                    <dt class="col-sm-4">Actief</dt><dd class="col-sm-8">{{ $product->is_active ? 'Ja' : 'Nee' }}</dd>
                </dl>
            </div>
        </div>
        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Bewerk</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Terug</a>
        </div>
    </div>
</div>
@endsection