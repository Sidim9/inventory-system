@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <h1 class="mb-4">Nieuw product</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Naam <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">SKU <span class="text-danger">*</span></label>
                    <input type="text" name="sku" class="form-control" value="{{ old('sku') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">EAN</label>
                    <input type="text" name="ean" class="form-control" value="{{ old('ean') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Type / categorie</label>
                    <input type="text" name="type" class="form-control" value="{{ old('type') }}" placeholder="bijv. hoesje, kabel, oplader">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kleur</label>
                    <input type="text" name="color" class="form-control" value="{{ old('color') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prijs (€)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Voorraad <span class="text-danger">*</span></label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Minimum voorraad</label>
                    <input type="number" name="minimum_stock" class="form-control" value="{{ old('minimum_stock', 0) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Pickvolgorde</label>
                    <input type="number" name="pick_order" class="form-control" value="{{ old('pick_order', 0) }}">
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" checked>
                        <label class="form-check-label" for="isActive">Actief</label>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Opslaan</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Annuleren</a>
            </div>
        </form>
    </div>
</div>
@endsection