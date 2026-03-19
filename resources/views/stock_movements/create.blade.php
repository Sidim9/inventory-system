@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="mb-4">Nieuwe voorraadbeweging</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('stock_movements.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Product</label>
                <select name="product_id" class="form-select">
                    <option value="">-- Selecteer product --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }} ({{ $product->sku }}) - Voorraad: {{ $product->stock }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Order (optioneel)</label>
                <select name="order_id" class="form-select">
                    <option value="">-- Geen order --</option>
                    @foreach ($orders as $order)
                        <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>{{ $order->order_number }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>In</option>
                    <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Uit</option>
                    <option value="adjustment" {{ old('type') == 'adjustment' ? 'selected' : '' }}>Aanpassing</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Hoeveelheidswijziging</label>
                <input type="number" name="quantity_change" class="form-control" value="{{ old('quantity_change', 0) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Notitie</label>
                <textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Opslaan</button>
            <a href="{{ route('stock_movements.index') }}" class="btn btn-secondary">Annuleren</a>
        </form>
    </div>
</div>
@endsection
