@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="mb-4">Voorraadbeweging</h1>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-5">Product</dt><dd class="col-sm-7">{{ $stockMovement->product->name ?? 'Onbekend' }} ({{ $stockMovement->product->sku ?? '' }})</dd>
                    <dt class="col-sm-5">Order</dt><dd class="col-sm-7">{{ $stockMovement->order->order_number ?? 'Geen' }}</dd>
                    <dt class="col-sm-5">Type</dt><dd class="col-sm-7"><span class="badge bg-secondary">{{ $stockMovement->type }}</span></dd>
                    <dt class="col-sm-5">Hoeveelheidswijziging</dt><dd class="col-sm-7">{{ $stockMovement->quantity_change > 0 ? '+' : '' }}{{ $stockMovement->quantity_change }}</dd>
                    <dt class="col-sm-5">Voorraad voor</dt><dd class="col-sm-7">{{ $stockMovement->stock_before }}</dd>
                    <dt class="col-sm-5">Voorraad na</dt><dd class="col-sm-7">{{ $stockMovement->stock_after }}</dd>
                    <dt class="col-sm-5">Notitie</dt><dd class="col-sm-7">{{ $stockMovement->note ?? '-' }}</dd>
                    <dt class="col-sm-5">Aangemaakt op</dt><dd class="col-sm-7">{{ $stockMovement->created_at->format('d-m-Y H:i') }}</dd>
                </dl>
            </div>
        </div>
        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('stock_movements.edit', $stockMovement->id) }}" class="btn btn-primary">Bewerk</a>
            <a href="{{ route('stock_movements.index') }}" class="btn btn-secondary">Terug</a>
        </div>
    </div>
</div>
@endsection
