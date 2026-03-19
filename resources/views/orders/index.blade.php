@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Orders</h1>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">Nieuwe order</a>
</div>

@forelse ($orders as $order)
    <div class="card mb-2 border-0 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <span>
                <strong>{{ $order->order_number }}</strong> &mdash;
                {{ $order->marketplace->name ?? 'Geen marketplace' }} &mdash;
                <span class="badge bg-secondary">{{ $order->status }}</span>
            </span>
            <div class="d-flex gap-2">
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">Bekijk</a>
                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-outline-primary">Bewerk</a>
                <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Weet je het zeker?')">Verwijder</button>
                </form>
            </div>
        </div>
    </div>
@empty
    <p class="text-muted">Geen orders gevonden.</p>
@endforelse
@endsection