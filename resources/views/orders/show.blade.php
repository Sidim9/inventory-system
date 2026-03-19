@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="mb-4">Order</h1>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-5">Order nummer</dt><dd class="col-sm-7">{{ $order->order_number }}</dd>
                    <dt class="col-sm-5">Externe order ID</dt><dd class="col-sm-7">{{ $order->external_order_id ?: '-' }}</dd>
                    <dt class="col-sm-5">Marketplace</dt><dd class="col-sm-7">{{ $order->marketplace->name ?? '-' }}</dd>
                    <dt class="col-sm-5">Status</dt><dd class="col-sm-7"><span class="badge bg-secondary">{{ $order->status }}</span></dd>
                    <dt class="col-sm-5">Klant</dt><dd class="col-sm-7">{{ $order->customer_name ?: '-' }}</dd>
                    <dt class="col-sm-5">Email</dt><dd class="col-sm-7">{{ $order->customer_email ?: '-' }}</dd>
                    <dt class="col-sm-5">Sort order</dt><dd class="col-sm-7">{{ $order->sort_order }}</dd>
                </dl>
            </div>
        </div>
        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary">Bewerk</a>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Terug</a>
        </div>
    </div>
</div>
@endsection