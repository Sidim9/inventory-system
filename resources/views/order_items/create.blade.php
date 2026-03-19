@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="mb-4">Nieuwe orderregel</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('order_items.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Order</label>
                <select name="order_id" class="form-select">
                    <option value="">-- Selecteer order --</option>
                    @foreach ($orders as $order)
                        <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>{{ $order->order_number }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Product (optioneel)</label>
                <select name="product_id" class="form-select">
                    <option value="">-- Geen product --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }} ({{ $product->sku }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">SKU</label>
                <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Productnaam</label>
                <input type="text" name="product_name" class="form-control" value="{{ old('product_name') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Aantal</label>
                <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1">
            </div>
            <button type="submit" class="btn btn-primary">Opslaan</button>
            <a href="{{ route('order_items.index') }}" class="btn btn-secondary">Annuleren</a>
        </form>
    </div>
</div>
@endsection
