@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <h1 class="mb-4">Product bewerken</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Naam <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">SKU <span class="text-danger">*</span></label>
                    <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">EAN</label>
                    <input type="text" name="ean" class="form-control" value="{{ old('ean', $product->ean) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Type / categorie</label>
                    <input type="text" name="type" class="form-control" value="{{ old('type', $product->type) }}" placeholder="bijv. hoesje, kabel, oplader">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kleur</label>
                    <input type="text" name="color" class="form-control" value="{{ old('color', $product->color) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prijs (€)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Voorraad <span class="text-danger">*</span></label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Minimum voorraad</label>
                    <input type="number" name="minimum_stock" class="form-control" value="{{ old('minimum_stock', $product->minimum_stock) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Pickvolgorde</label>
                    <input type="number" name="pick_order" class="form-control" value="{{ old('pick_order', $product->pick_order) }}">
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" {{ $product->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">Actief</label>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Updaten</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Annuleren</a>
            </div>
        </form>
    </div>
</div>
@endsection