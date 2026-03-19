@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="mb-4">Orderregel</h1>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Order</dt><dd class="col-sm-8">{{ $orderItem->order->order_number ?? 'Onbekend' }}</dd>
                    <dt class="col-sm-4">Product</dt><dd class="col-sm-8">{{ $orderItem->product->name ?? 'Geen' }} ({{ $orderItem->product->sku ?? '' }})</dd>
                    <dt class="col-sm-4">SKU</dt><dd class="col-sm-8">{{ $orderItem->sku }}</dd>
                    <dt class="col-sm-4">Productnaam</dt><dd class="col-sm-8">{{ $orderItem->product_name }}</dd>
                    <dt class="col-sm-4">Aantal</dt><dd class="col-sm-8">{{ $orderItem->quantity }}</dd>
                    <dt class="col-sm-4">Aangemaakt op</dt><dd class="col-sm-8">{{ $orderItem->created_at->format('d-m-Y H:i') }}</dd>
                </dl>
            </div>
        </div>
        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('order_items.edit', $orderItem->id) }}" class="btn btn-primary">Bewerk</a>
            <a href="{{ route('order_items.index') }}" class="btn btn-secondary">Terug</a>
        </div>
    </div>
</div>
@endsection
