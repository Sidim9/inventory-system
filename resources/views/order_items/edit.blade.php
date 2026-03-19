@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <h1 class="mb-4">Orderregel bewerken</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('order_items.update', $orderItem->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Order <span class="text-danger">*</span></label>
                    <select name="order_id" class="form-select" required>
                        <option value="">-- Selecteer order --</option>
                        @foreach ($orders as $order)
                            <option value="{{ $order->id }}" {{ old('order_id', $orderItem->order_id) == $order->id ? 'selected' : '' }}>{{ $order->order_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Product (optioneel)</label>
                    <select name="product_id" class="form-select">
                        <option value="">-- Geen product --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $orderItem->product_id) == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} — {{ $product->ean ?: $product->sku }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">EAN</label>
                    <input type="text" name="ean" class="form-control" value="{{ old('ean', $orderItem->ean) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" value="{{ old('sku', $orderItem->sku) }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Productnaam <span class="text-danger">*</span></label>
                    <input type="text" name="product_name" class="form-control" value="{{ old('product_name', $orderItem->product_name) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Stukprijs (€)</label>
                    <input type="number" step="0.01" name="unit_price" class="form-control" value="{{ old('unit_price', $orderItem->unit_price) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Aantal <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $orderItem->quantity) }}" min="1" required>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Updaten</button>
                <a href="{{ route('orders.show', $orderItem->order_id) }}" class="btn btn-secondary">Annuleren</a>
            </div>
        </form>
    </div>
</div>
@endsection